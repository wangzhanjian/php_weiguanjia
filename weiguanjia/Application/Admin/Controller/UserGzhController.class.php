<?php
/**
 * Created by PhpStorm.
 * User: 天昊
 * Date: 2016/11/24
 * Time: 10:15
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Page;
class UserGzhController extends Controller
{
    //显示用户及其基本信息列表
    Public function index(){
        $db = M('User');//连接数据库
        $count = $db->count();
        $Page = new Page($count,10);
        $show = $Page->show();//创建分页
        $list = $db->order('Id')->field('username,id,nickname')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
    //显示服务器所有公众号信息列表
    Public function gzhList(){
        $db = M('project');//连接数据库
        $count = $db->count();
        $Page = new Page($count,10);
        $show = $Page->show();//创建分页
        $list = $db->order('Id')->field('Id,user_id,app_name')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
}