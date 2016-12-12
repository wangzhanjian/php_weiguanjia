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
    //检查用户是否登录
    protected function isLogin(){
       return session('?'.C('SESSION_USER_ID'));
    }

    //返回用户所有项目列表详细信息【与project表各字段信息一致】，供项目中心及开发模块使用 ok
    protected function getProjectList(){
        $list=M('project');
        return $list->where(array('user_id'=>session('user_id')))->select();
    }

    //分配项目中心开发模块共同信息 ok
    protected function assignProjectCenterCommonInfo(){
        //分配用户所有项目列表详细信息给模板，请只在模板显示你需要的部分，以防信息泄露！
        $this->assign('projectList',$this->getProjectList());
        //分配用户当前操作的公众号名称给模板，用于项目中心隐藏菜单的激活判断
        $this->assign('current_app_name',session(C('SESSION_APP_INFO'))['app_name']);
        //分配全局session信息给模板使用包括（用户id，用户昵称，和正在操作的公众号的详细信息【与project数据表字段一致】），谨慎输出！
        $this->assign('GLOBAL_INFO',session());
    }

}