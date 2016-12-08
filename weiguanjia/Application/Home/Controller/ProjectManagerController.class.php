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
    //显示项目中心主页面 ok
    public function centerPage(){
        if($this->isLogin()){
            $this->centerPageInit();
            $this->display('ProjectManager/centerPage');
        }else{
            $this->error('请先登录！','/Home/UserManager/loginPage',2);
        }
    }

    //初始化项目中心页面信息 ok
    protected function centerPageInit(){
        $projectList=$this->getProjectList();
        //检查有没有已保存项目信息
        if(session(C('SESSION_APP_INFO'))){
            $this->assign('current_app_name',session(C('SESSION_APP_INFO'))['app_name']);
        }else{
            session(C('SESSION_APP_INFO'),$projectList[0]);    //保存当前项目详细信息
            $this->assign('current_app_name',$projectList[0]['app_name']);
        }
        $this->assign('GLOBAL_INFO',session());
        $this->assign('projectList',$projectList);
    }

    //新建项目操作 ok
    public function create(){
        if($this->isLogin()){
            $project=D('Project');
            $data=I('post.');
            $data['user_id']=session(C('SESSION_USER_ID'));
            if($project->create($data)){
                $project->add();
                session(C('SESSION_APP_INFO'),$data);              //将当前项目状态切换到新建的项目中
                $this->configPrompt();
            }else{
                $this->error($project->getError(),'centerPage',2);
            }
        }else{
            $this->error('请先登录！','/Home/UserManager/loginPage',2);
        }
    }

    //删除项目
    public function delete(){

    }

    //返回项目信息详情
    public function info(){

    }

    //项目配置信息提示页面
    Protected function configPrompt(){
        $this->assign('GLOBAL_INFO',session());
        $this->display('configPrompt');
    }

    //显示查看公众号页面
    public function gzhInfo(){
        $this->display();
    }

    //项目切换 ok
    public function switching(){
        if($this->isLogin()){
            $project=M('project');
            $map=array('user_id'=>session(C('SESSION_USER_ID')),'app_name'=>I('get.app_name'));
            $data=$project->where($map)->find();
            if($data){
                session(C('SESSION_APP_INFO'),$data);  //保存最新的项目信息
                $this->centerPage();
            }else{
                $this->error('项目切换失败！','centerPage',2);
            }
        }else{
            $this->error('请先登录！','/home/UserManager/loginPage',2);
        }
    }

    //返回公众号app_secreat
    public function gahAppSecret(){

    }
}