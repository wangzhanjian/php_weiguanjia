<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    //显示首页信息
    public function index(){
        $shufflingImg=$this->shufflingImg();
        $this->assign('shufflingImg',$shufflingImg);
        $latestDynamic=$this->latestDynamic();
        $this->assign('latestDynamic',$latestDynamic);
        $specialRecommendation=$this->specialRecommendation();
        $this->assign('specialRecommendation',$specialRecommendation);
        $this->display();

    }

    //显示关于我们静态页面
    function aboutUs(){
        $this->display();
    }
    //获取图片轮播资源
    protected function shufflingImg(){
        $img=M('shuffling_img');
        $data=$img->where(1)->field('src')->order('Id desc')->limit(3)->select();
       return $data;
    }

    //获取最新动态资源
    protected function latestDynamic(){
        $dynamic=M('dynamic');
        $data=$dynamic->where(1)->field('title,createtime')->order('Id desc')->limit(5)->select();
        return $data;

    }

    //获取特色推荐资源
    protected function specialRecommendation(){
        $recommendation=M('features');
        $data=$recommendation->where(1)->field('title,createtime')->order('Id desc')->limit(5)->select();
        return $data;

    }

    //获取项目展示资源
    protected function projectDisplay(){

    }


}