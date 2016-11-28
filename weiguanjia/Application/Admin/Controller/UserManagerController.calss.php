<?php
/**
 * Created by PhpStorm.
 * User: ji
 * Date: 2016/11/21
 * Time: 15:16
 */

namespace Admin\Controller;


use Think\Controller;

class UserManagerController extends Controller
{
    //显示用户及其基本信息列表
    Public function index(){
        $db = M('User');//连接数据库
        $count = $db->count();
        $Page = new Page($count,10);
        $show = $Page->show();//创建分页
        $list = $db->order('Id')->field('username')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
        $this->display();
    }
    //显示服务器所有公众号信息列表
    Public function gzhList(){

        $this->display();
    }
    //返回用户个数
    Public function userCount(){

    }
    //返回公众号个数
    Public function gzhCount(){

    }
    //显示用户详情
    Public function userInfo(){

    }
    //显示公众号详情
    Public function gzhInfo(){

    }
}