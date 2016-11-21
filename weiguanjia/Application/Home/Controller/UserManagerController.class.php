<?php
/**
 * Created by PhpStorm.
 * User: ji
 * Date: 2016/11/21
 * Time: 13:46
 */

namespace Home\Controller;


use Think\Controller;

class UserManagerController extends Controller
{
    //显示用户登录页面
    public function loginPage(){
        $this->display();
    }

    //登录处理
    public function login(){

    }

    //显示用户注册页面
    public function registerPage(){
        $this->display();
    }

    //注册处理
    public function register(){

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

    //显示用户公众公众号信息页
    public function gzhList(){
        $this->display();
    }
}