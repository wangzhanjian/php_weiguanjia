<?php
/**
 * Created by PhpStorm.
 * User: ji
 * Date: 2016/11/21
 * Time: 13:46
 */

namespace Home\Controller;


use Nette\Mail\Message;
use Nette\Mail\SmtpMailer;

class UserManagerController extends BasisController
{
    //显示用户登录页面 ok
    public function loginPage(){
        if( cookie('remember_username') && cookie('remember_password') ){
            $this->assign('remember_username',cookie('remember_username'));
            $this->assign('remember_password',cookie('remember_password'));
        }
        $this->display();
    }

    //登录处理 ok
    public function login(){
        $info=$this->checkLoginInfo();  //检查用户名密码是否正确
        if ($info){
            //判断是否记住密码并进行处理
            if(I('post.remember_password')=='on'){
                $this->rememberPassword();
            }
            //设置session信息
            session(C('SESSION_USER_ID'),$info['id']);
            session(C('SESSION_USER_NICKNAME'),$info['nickname']);
            redirect('/Home');   //跳转到首页
        }else{
            $this->error('登录失败',"loginPage",2);
        }
    }

    //检查登录的用户名密码是否存在 ok
    protected function checkLoginInfo(){
        //获取表单数据
        $username = I('post.username');
        $password = md5(I('post.password'));
        //数据库查找
        $user = M('user'); //实例化User对象
        $data = $user->where(array('username'=>$username, 'password'=>$password))->find();
        if($data){
            return $data;       //如果用户名密码正确，返回用户信息
        }else{
            $this->error('用户名或密码错误！','loginPage',2);
        }
    }

    //显示用户注册页面 ok
    public function registerPage(){
        $this->display();
    }

    //注册处理 ok
    public function register(){
        //检查用户注册信息是否正确
        if ($this->checkUserExist()&&$this->checkInfo()){
            $User = M('user');
            $data = array('username' => trim(I('post.username')), 'password' => md5(I('post.password')));
            $User->add($data);
            $this->success('注册成功！','loginPage',2);
        }else{
            $this->error('注册失败！',"registerPage",2);
        }
    }

    //检查用户名是否已注册ajax请求接口 ok
    public function checkUserExistAjax(){
        $username = trim(I('post.username'));
        $user = M('user');
        $data = $user->where(array('username'=>$username))->find();
        if($data){
            echo '已注册';
        }else{
            echo '未注册';
        }
    }

    //检查用户是否存在 ok
    protected function checkUserExist(){
        $username = trim(I('post.username'));
        $user = M('user');
        $data = $user->where(array('username'=>$username))->find();
        if($data){
            $this->error('用户名已注册','registerPage',2);
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
            }
        }else{
            $this->error('密码必须6-16位非空字符组成','registerPage',2);
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
        }
    }

    //退出登录 ok
    public function userExit(){
        session('[destroy]');
        redirect('/Home');
    }

    //记住密码 ok
    protected function rememberPassword(){
        cookie('remember_username',trim(I('post.username')),3600*24*7); // 指定用户名保存一周
        cookie('remember_password',trim(I('post.password')),3600*24*7); // 指定密码保存一周
    }

    //忘记密码 ok
    public function forgetPassword(){
        if(session('?'.C('SESSION_EMAIL_VERIFY_CODE'))){
            //检查验证码发送是否已过一分钟
            $existTime=time()-session(C('SESSION_EMAIL_VERIFY_CODE'))['create_time'];
            if($existTime<60){
                $this->assign('verify_state',60-$existTime);
            }
        }
        $this->display();
    }

    //找回密码时发送验证码ajax调用接口
    public function sendVerifyCodeForFindPasswordAjax(){
        $username = trim(I('post.username'));
        if($this->userExist($username)){       //判断要找回密码的用户名是否存在
            if($this->canSendFindPswdVerifyCode()) {        //判断是否符合发送验证码的条件
                $this->sendFindPswdVerifyCode($username);
            }else{
                echo '发送验证码过于频繁，请稍后再试！';
            }
        }else{
            echo '无效的用户名！';
        }
    }

    //发送找回密码验证码
    protected function sendFindPswdVerifyCode($username){
        $emailRule = "/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/";
        $telRule = "/^13(\d{9})$|^15(\d{9})$|^189(\d{8})$/";
        if(preg_match($emailRule,$username)){   //发送邮件验证码
            $verifyCode=mt_rand(1000,9999);
            session(C('SESSION_EMAIL_VERIFY_CODE'),array('username'=>$username,'code'=>$verifyCode,'create_time'=>time(),'state'=>0),60*10);
            $content="该验证码10分钟内有效 {$verifyCode}";
            if($this->sendEmailVerifyCode($username,$content)){
                echo 'success';
            }else{
                echo 'error';
            }
        }else if(preg_match($telRule,$username)){   //发送手机验证码

        }
    }

    //检查用户是否存在（用于找回密码）
    protected function userExist($username){
        $user=M('user');
        return $user->where(array('username'=>$username))->find();
    }

    //检查找回密码验证码的是否已过限制时间
    protected function canSendFindPswdVerifyCode(){
        if(session('?'.C('SESSION_EMAIL_VERIFY_CODE'))) {
            //检查验证码发送是否已过一分钟
            $existTime = time() - session(C('SESSION_EMAIL_VERIFY_CODE'))['create_time'];
            if ($existTime < 60) {
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }

    //发送邮件验证码
    protected function sendEmailVerifyCode($email,$content){
        //配置邮件服务器
        $mailer = new SmtpMailer([
            'host' => 'smtp.qq.com', // 设置 smtp 的服务器地址
            'username' => '317619554@qq.com', //发送邮件的 email
            'password' => 'rwajjejxtuxgbhdi',  //发送邮件的 email 密码
            'secure' => 'ssl', //设置安全协议为 ssl

        ]);
        //发送邮件配置
        $mail = new Message();
        $mail->setFrom('微管家 <317619554@qq.com>')
            //->addTo('zzm_xinyang@163.com')
            ->addTo($email)
            ->setSubject('验证码信息')
            ->setBody($content);
        $mailer->send($mail);
        return true;
    }

    //检验用户提交的验证码是否正确Ajax
    public function checkPswdVerifyCodeAjax(){
        $code=I('post.verify_code');
        if($code==session(C('SESSION_EMAIL_VERIFY_CODE'))['code']){
            $createTime=session(C('SESSION_EMAIL_VERIFY_CODE'))['create_time'];
            $username=session(C('SESSION_EMAIL_VERIFY_CODE'))['username'];
            session(C('SESSION_EMAIL_VERIFY_CODE'),array('username'=>$username,'code'=>$code,'create_time'=>$createTime,'state'=>1));
            echo 'success';
        }else{
            echo 'failure';
        }
    }

    //找回密码修改Ajax
    public function findPswdAjax(){
        if(session(C('SESSION_EMAIL_VERIFY_CODE'))['state']){
            if($this->checkRegisterPswd()){
                $user = M('user');
                $data = array('password'=> md5(trim(I('post.password'))));
                $user->where(array('username'=> session(C('SESSION_EMAIL_VERIFY_CODE'))['username']))->setField($data);
                session('[destroy]');
                echo 'success';
            }else{
               echo '密码格式不正确！';
            }
        }else{
           echo '您无权操作！';
        }
    }

    //显示个人信息页面 ok
    public function info(){
        if($this->isLogin()){
            $data = $this->getInfo();
            $this->assign('info',$data);
            $this->assign('GLOBAL_INFO',session());
            $this->display();
        }else{
            $this->error('请先登录！','loginPage',2);
        }
    }

    //获取个人信息页面数据 ok
    protected function getInfo(){
        $user= M('user');
        return $user->where(array('id'=>session('user_id')))->field("nickname,username")->find();
    }

    //修改个人信息处理 ok
    public function updateInfoAjax(){
        if($this->isLogin()){
            $nickname=trim(I('get.nickname'));
            $len=strlen($nickname);
            if($len <=0 || $len>=10){       //检查昵称长度
                echo '昵称长度不对！';
            }else{
                $user=M('user');
                $user->where(array('id'=>session(C('SESSION_USER_ID'))))->save(array('nickname'=>$nickname));
                session(C('SESSION_USER_NICKNAME'),$nickname);  //更新session状态
                echo 'success';
            }
        }else{
            echo '您无权操作！';
        }
    }

    //拉取修改密码页面 ok
    public function modifyPasswordPage(){
        if($this->isLogin()){
            $this->assign('GLOBAL_INFO',session());
            $this->display();
        }else{
            $this->error('请先登录！','loginPage',2);
        }
    }

    //修改密码处理 ok
    public function updatePassword(){
        if($this->isLogin()){
            if ($this->checkModifyPswd()){
                $user = M('user');
                $data = array('password'=> md5(trim(I('post.new_password'))));
                $user->where(array('id'=>session('user_id')))->setField($data);
                $this->success('密码修改成功,请重新登录！','userExit',2);
            }else{
                $this->error('密码修改失败！','modifyPasswordPage',2);
            }
        }else{
            $this->error('请先登录！','loginPage',2);
        }
    }

    //检查修改密码是否符合规则 ok
    protected function checkModifyPswd(){
        $oldPassword = I('post.old_password');
        $password = I('post.new_password');
        $affirmPassword = I('post.affirm_password');
        if($this->checkPswdEqual($oldPassword,$password)){
            $this->error('新旧密码一致，修改失败！','modifyPasswordPage',2);
        }else{
            if ($this->checkPswdRule($password)){
                if($this->checkPswdEqual($password,$affirmPassword)){
                    return true;
                }else{
                    $this->error('两次密码不一致！','modifyPasswordPage',2);
                }
            }else{
                $this->error('密码必须6-16位非空字符组成','modifyPasswordPage',2);
            }
        }
    }

    //显示用户公众公众号信息列表页 ok
    public function gzhList(){
        if($this->isLogin()){
            $list=$this->getGzhListInfo();  //获取公众号信息列表
            $this->assign('gzh',$list);
            $this->assign('GLOBAL_INFO',session());     //分配全局信息
            $this->display();
        }else{
            $this->error('请先登录！','loginPage',2);
        }
    }

    //获取用户公众号列表 ok
    protected function getGzhListInfo(){
        $pro = M('project'); //实例化User对象
        return $pro->where(array('user_id' =>session('user_id')))->field("app_name")->select();
    }

    //删除公众号 ok
    public function gzhDel(){
        if($this->isLogin()){
            $appName=I('get.app_name');
            $project=M('project');
            $project->where(array('user_id'=>session(C('SESSION_USER_ID')),'app_name'=>$appName))->delete();
            if($project){
                $this->redirect('gzhList');
            }else{
                $this->error('操作失败！','gzhList',2);
            }
        }else{
           $this->error('请先登录！','loginPage',2);
        }
    }

}