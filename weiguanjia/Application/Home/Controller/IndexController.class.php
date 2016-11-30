<?php
namespace Home\Controller;

class IndexController extends BasisController {
    //显示首页信息
    public function index(){
        //获取轮播图资源
        $shufflingImg=$this->shufflingImg();
        $this->assign('shufflingImg',$shufflingImg);
        //获取最新动态资源
        $latestDynamic=$this->latestDynamic();
        $this->assign('latestDynamic',$latestDynamic);
        //获取特别推荐内容
        $specialRecommendation=$this->specialRecommendation();
        $this->assign('specialRecommendation',$specialRecommendation);
        //下发用户信息（包含在全局数组中）
        $this->assign('GLOBAL_INFO',session());
        $this->display('Index/index');

    }

    //显示关于我们静态页面
    public function aboutUs(){
        $this->assign('GLOBAL_INFO',session());
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