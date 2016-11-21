<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    //显示首页信息
    public function index(){
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