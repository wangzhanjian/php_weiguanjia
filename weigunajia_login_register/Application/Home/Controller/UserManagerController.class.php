<?php
/**
 * Created by PhpStorm.
 * User: ji
 * Date: 2016/11/21
 * Time: 13:46
 */

namespace Home\Controller;


use Think\Controller;
use Think\Log\Driver\Sae;

class UserManagerController extends Controller
{
    //显示用户登录页面
    public function loginPage(){
        $this->display();
    }

    //登录处理
    public function login(){
        //获取表单数据
        $info=$this->checkLoginInfo();
        if ($info){
            session(array('user_id'=>$info));
            $this->display("Index/index");
        }else{
            $this->display("loginPage");
        }
    }

    //检查登录用户名密码是否存在
    protected function checkLoginInfo(){
        //获取表单数据
        $username = I('post.username');
        $password = I('post.password');
        //数据库查找
        if($this->check_verify()){
            $users = M('user'); //实例化User对象
            $data = $users->where(array(
                'username'=>$username,
                'password'    =>$password
            ))->find();
            if ($data){
                $this->assign("nickname",$data['nickname']);
                return $data['id'];
            }else{
                $this->assign('result','用户名密码输入错误');
                return false;
            }
        }else{
            return false;
        }
    }

    //显示用户注册页面
    public function registerPage(){
        $this->display();
    }

    //注册处理
    public function register(){
        //检查用户注册信息是否正确
        if ($this->checkInfo()&&$this->checkUserUnique()){
            //信息正确，倒入数据表
            $User = M('user'); //实例化User对象
            //写入数据库
            $data = array(
                'username' => I('post.username'),
                'password'     =>  I('post.password'),
            );
            $r = $User->add($data);
            $this->assign('result',"OK");
            $this->success('注册成功！','loginPage',3);
        }else{
            $this->display("registerPage");
        }
    }

    //检查用户注册信息是否符合规则
    protected function checkInfo(){
        if ($this->checkUsername()&&$this->checkPswd()&&$this->check_verify()){
            return true;
        }else{
            return false;
        }
    }

    //检查用户名唯一性
    protected function checkUserUnique(){
        $username = I('post.username');
        $user = M('user');
        $data = $user->where(array(
            'username'=>$username,
        ))->find();
        if ($data){
            $this->assign('result','用户名已被注册');
            $this->display('loginPage');
            return false;
        }else{
            return true;
        }
    }

    //检查用户名是否符合规则
    protected function checkUsername(){
        $username = I('post.username');
        $email = "/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/";
        $bool=preg_match($email,$username);
        $tel = "/^13(\d{9})$|^15(\d{9})$|^189(\d{8})$/";
        $bools=preg_match($tel,$username);
        if ($bool || $bools){
            return true;
        }else{
            $this->assign('result','用户名输入错误');
            return false;
        }
    }

    //检查用户密码是否符合规则
    protected function checkPswd(){
        $password = I('post.password');
        $affirm_password = I('post.affirm_password');
        $pswd = "/(?!^\\d+$)(?!^[a-zA-Z]+$)(?!^[_#@]+$).{6,16}/";
        $bool=preg_match($pswd,$password);
        if ($bool&&$password==$affirm_password){
            return true;
        }else{
            $this->assign('result','密码输入错误');
            return false;
        }
    }

    //生成验证码
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

    // 检测输入的验证码是否正确，$code为用户输入的验证码字符串
    protected function check_verify(){
        $code=I('post.verify_code');
        $verify = new \Think\Verify();
        if($verify->check($code, $id='')){
            return true;
        }else{
            $this->assign('result','验证码错误！');
            return false;
        }
    }

    //退出登录
    public function userExit(){

    }

    //记住密码
    public function rememberPassword(){

    }

    //忘记密码
    public function forgetPassword(){

    }

    //显示个人信息页面
    public function info(){
        $this->display();
    }

    //显示修改个人信息页（暂无）
    public function modifyInfoPage(){
        $this->display();
    }

    //修改个人信息处理
    public function updateinfo(){

    }

    //拉取修改密码页面
    public function modifyPasswordPage(){
        $this->display();
    }

    //修改密码处理
    public function updatePassword(){

    }

    //显示用户公众公众号信息列表页
    public function gzhList(){
        $this->display();
    }
}