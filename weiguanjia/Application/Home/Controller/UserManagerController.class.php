<?php
/**
 * Created by PhpStorm.
 * User: ji
 * Date: 2016/11/21
 * Time: 13:46
 */

namespace Home\Controller;


class UserManagerController extends BasisController
{
    //显示用户登录页面 ok
    public function loginPage(){
        $this->display('UserManager/loginPage');
    }

    //登录处理 ok
    public function login(){
        //获取表单数据
        $info=$this->checkLoginInfo();
        if ($info){
            session('user_id',$info['id']);
            session('nickname',$info['nickname']);
            $this->assignNickname();
            $index=new IndexController();
            $index->index();
            return true;
        }else{
            $this->error('登录失败',"loginPage",2);
            return false;
        }
    }

    //检查登录的用户名密码是否存在 ok
    protected function checkLoginInfo(){
        //获取表单数据
        $username = I('post.username');
        $password = I('post.password');
        //数据库查找
        $user = M('user'); //实例化User对象
        $data = $user->where(array('username'=>$username, 'password'=>$password))->find();
        if($data){
            return $data;
        }else{
            $this->error('用户名或密码错误！','loginPage',2);
            return false;
        }
    }

    //显示用户注册页面 ok
    public function registerPage(){
        $this->display();
    }

    //注册处理 ok
    public function register(){
        //检查用户注册信息是否正确
        if ($this->checkUserUnique()&&$this->checkInfo()){
            $User = M('user');
            $data = array('username' => trim(I('post.username')), 'password' => I('post.password'));
            $User->add($data);
            $this->success('注册成功！','loginPage',2);
            return true;
        }else{
            $this->error('注册失败！',"registerPage",2);
            return false;
        }
    }

    //检查用户名是否已注册ajax请求接口 ok
    public function checkUserUniqueAjax(){
        $username = trim(I('post.username'));
        $user = M('user');
        $data = $user->where(array('username'=>$username))->find();
        if($data){
            echo '已注册';
            return false;
        }else{
            echo '未注册';
            return true;
        }
    }

    //检查用户名唯一性 ok
    protected function checkUserUnique(){
        $username = trim(I('post.username'));
        $user = M('user');
        $data = $user->where(array('username'=>$username))->find();
        if($data){
            $this->error('用户名已注册','registerPage',2);
            return false;
        }else{
            return true;
        }
    }

    //检查用户注册信息是否符合规则 ok
    protected function checkInfo(){
        if ($this->checkUsername() && $this->checkRegisterPswd() && $this->check_verify()){
            return true;
        }else{
            return false;
        }
    }

    //检查用户名是否符合规则 ok
    protected function checkUsername(){
        $username = trim(I('post.username'));
        $email = "/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/";
        $bool=preg_match($email,$username);
        $tel = "/^13(\d{9})$|^15(\d{9})$|^189(\d{8})$/";
        $bools=preg_match($tel,$username);
        if ($bool || $bools){
            return true;
        }else{
            $this->error('用户名格式不正确！','registerPage',2);
            return false;
        }
    }

    //检查用户注册的密码是否符合规则 ok
    protected function checkRegisterPswd(){
        $password = I('post.password');
        $affirmPassword = I('post.affirm_password');
        if ($this->checkPswdRule($password)){
            if($this->checkPswdEqual($password,$affirmPassword)){
                return true;
            }else{
                $this->error('两次密码不一致','registerPage',2);
                return false;
            }
        }else{
            $this->error('密码必须6-16位非空字符组成','registerPage',2);
            return false;
        }
    }

    //检查密码是否符合规则 ok
    protected function checkPswdRule($password){
        $rule = "/\S{6,16}/";
        if (preg_match($rule,$password)){
            return true;
        }else{
            return false;
        }
    }

    //检查密码是否一致 ok
    protected function checkPswdEqual($password,$affirmPassword){
        if($password == $affirmPassword){
            return true;
        }else{
            return false;
        }
    }

    //生成验证码 ok
    public function getVerify(){
        $config =    array(
            'fontSize'    =>    50,    // 验证码字体大小
            'length'      =>    4,     // 验证码位数
            'useNoise'    =>    50,// 关闭验证码杂点
            'useCurve'    =>false,
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }

    // 检测输入的验证码是否正确 ok
    protected function check_verify(){
        $code=I('post.verify_code');
        $verify = new \Think\Verify();
        if($verify->check($code, $id='')){
            return true;
        }else{
            $this->error('验证码不正确！','registerPage',2);
            return false;
        }
    }

    //退出登录 ok
    public function userExit(){
        session('[destroy]');
        $this->assignNickname();
        $index=new IndexController();
        $index->index();
    }

    //记住密码
    public function rememberPassword(){

    }

    //忘记密码
    public function forgetPassword(){

    }

    //显示个人信息页面 ok
    public function info(){
        if($this->checkLogin()){
            $data = $this->getInfo();
            $this->assign('info',$data);
            $this->assignNickname();
            $this->display();
        }else{
            $this->error('请先登录！','loginPage',2);
            return false;
        }
    }

    //获取个人信息页面数据 ok
    protected function getInfo(){
        $user= M('user');
        $data = $user->where(array('id'=>session('user_id')))->field("nickname,username")->find();
        return $data;
    }

    //显示修改个人信息页（暂无）
    public function modifyInfoPage(){
        $this->display();
    }

    //修改个人信息处理
    public function updateInfo(){
        //echo trim(I('get.nickname'));
        echo 'success';
        return true;
    }

    //拉取修改密码页面 ok
    public function modifyPasswordPage(){
        if($this->checkLogin()){
            $this->assignNickname();
            $this->display();
        }else{
            $this->error('请先登录！','loginPage',2);
            return false;
        }
    }

    //修改密码处理 ok
    public function updatePassword(){
        if($this->checkLogin()){
            if ($this->checkModifyPswd()){
                $user = M('user');
                $data = array('password'=> I('post.new_password'));
                $user->where(array('id'=>session('user_id')))->setField($data);
                $this->success('密码修改成功,请重新登录！','userExit',2);
                return true;
            }else{
                $this->error('密码修改失败！','modifyPasswordPage',2);
                return false;
            }
        }else{
            $this->error('请先登录！','loginPage',2);
            return false;
        }
    }

    //检查修改密码是否符合规则 ok
    protected function checkModifyPswd(){
        $oldPassword = I('post.old_password');
        $password = I('post.new_password');
        $affirmPassword = I('post.affirm_password');
        if($this->checkPswdEqual($oldPassword,$password)){
            $this->error('新旧密码一致，修改失败！','modifyPasswordPage',2);
            return false;
        }else{
            if ($this->checkPswdRule($password)){
                if($this->checkPswdEqual($password,$affirmPassword)){
                    return true;
                }else{
                    $this->error('两次密码不一致！','modifyPasswordPage',2);
                    return false;
                }
            }else{
                $this->error('密码必须6-16位非空字符组成','modifyPasswordPage',2);
                return false;
            }
        }
    }

    //显示用户公众公众号信息列表页
    public function gzhList(){
        if($this->checkLogin()){
            $list=$this->getGzhListInfo();
            $this->assign('gzh',$list);
            $this->assignNickname();
            $this->display();
        }else{
            $this->error('请先登录！','loginPage',2);
            return false;
        }
    }

    //获取用户公众号列表
    protected function getGzhListInfo(){
        $pro = M('project'); //实例化User对象
        $data = $pro->where(array('user_id' =>session('user_id')))->field("app_name")->select();
        if ($data){
            return $data;
        }else{
            return false;
        }
    }
}