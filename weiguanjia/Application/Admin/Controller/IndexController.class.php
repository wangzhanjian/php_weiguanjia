<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $count['user'] = $this->userCount();
        $count['gzh'] = $this->gzhCount();
        $this->assign('count',$count);
        $this->display();
    }
    //获取用户总数
    public function userCount(){
        $db = M('User');
        $count = $db->count();
        return $count;
    }
    //获取公众号总数
    public function gzhCount(){
        $db = M('project');
        $count = $db->count();
        return $count;
    }
}
