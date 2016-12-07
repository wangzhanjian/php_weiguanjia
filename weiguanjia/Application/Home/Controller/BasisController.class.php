<?php
/**
 * Created by PhpStorm.
 * User: ji
 * Date: 2016/11/24
 * Time: 16:32
 */

namespace Home\Controller;


use Think\Controller;
use Wechat\AccessToken;

class BasisController extends Controller
{
    protected function isLogin(){
       return session('?'.C('SESSION_USER_ID'));
    }

    //返回项目列表详细信息 ok
    protected function getProjectList(){
        $list=M('project');
        return $list->where(array('user_id'=>session('user_id')))->select();
    }

    //分配项目中心模块共同信息
    protected function assignProjectCenterCommonInfo(){
        $this->assign('projectList',$this->getProjectList());
        $this->assign('current_app_name',session(C('SESSION_APP_INFO'))['app_name']);
        $this->assign('GLOBAL_INFO',session());
    }

}