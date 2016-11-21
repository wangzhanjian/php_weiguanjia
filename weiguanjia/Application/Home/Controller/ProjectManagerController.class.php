<?php
/**
 * Created by PhpStorm.
 * User: ji
 * Date: 2016/11/21
 * Time: 14:04
 */

namespace Home\Controller;

use Think\Controller;

class ProjectManagerController extends Controller
{
    //显示项目中心主页面
    public function centerPage(){
        $this->display();
    }

    //新建项目操作
    public function create(){

    }

    //删除项目
    public function delete(){

    }

    //返回项目列表信息
    public function projectList(){

    }

    //返回项目信息详情
    public function info(){

    }

    //项目配置信息提示页面
    public function configPrompt(){
        $this->display();
    }

    //显示查看公众号页面
    public function gzhInfo(){
        $this->display();
    }

    //项目切换
    public function switching(){

    }

    //返回公众号app_secreat
    public function gahAppSecret(){

    }
}