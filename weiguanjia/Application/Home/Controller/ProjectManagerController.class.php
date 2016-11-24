<?php
/**
 * Created by PhpStorm.
 * User: ji
 * Date: 2016/11/21
 * Time: 14:04
 */

namespace Home\Controller;


class ProjectManagerController extends BasisController
{
    //显示项目中心主页面
    public function centerPage(){
        $projectList=$this->projectList();
        $this->assign('projectList',$projectList);
        $this->display();
    }

    //新建项目操作
    public function create(){
        if($this->checkLogin()){
            $create=M('project');
            $data['user_id']=session('user_id');
            $create->create();
            $result=$create->add();
            if($result){
                $this->configPrompt();
            } else {
                error_log($result,3,'./Public/log/createlog.txt');
            }
        }else{
            $this->error('请先登录！','UserManager/loginPage',2);
        }
    }

    //删除项目
    public function delete(){

    }

    //返回项目列表信息
    public function projectList(){
        $list=M('project');
        $data=$list->where(1)->field('app_name')->select();
        return $data;

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
        $projectList=$this->projectList();
        $this->assign('projectList',$projectList);
        $this->display();
    }

    //项目切换
    public function switching(){
        $projectList=$this->projectList();
        $this->assign('projectList',$projectList);
        $this->display();

    }

    //返回公众号app_secreat
    public function gahAppSecret(){

    }
}