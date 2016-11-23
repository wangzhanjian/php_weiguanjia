<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    //显示首页信息
    public function index(){
        //判断用户是否已经登录
//        if(Session::is_set(C('USER_AUTH_KEY')))
//            //if(!isset($_SESSION['USER_AUTH_KEY'])||($_SESSION['USER_AUTH_KEY']==0))//不能用此句
//        {
//            $msg=Session::get(C('USER_AUTH_KEY'));
//
//        }
//
//        $this->assign('msg',$msg);

       $this->display();
    }

    //显示关于我们静态页面
    function aboutUs(){
        $this->display();
    }
    //获取图片轮播资源
    protected function shufflingImg(){

    }

    //获取最新动态资源
    protected function latestDynamic(){

    }

    //获取特色推荐资源
    protected function specialRecommendation(){

    }

    //获取项目展示资源
    protected function projectDisplay(){

    }


}