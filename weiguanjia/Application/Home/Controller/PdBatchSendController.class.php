<?php
/**
 * Created by PhpStorm.
 * User: 天昊
 * Date: 2016/12/15
 * Time: 13:58
 */

namespace Home\Controller;


class PdBatchSendController extends BasisController
{
    public function __construct()
    {
        parent::__construct();
        if(!$this->isLogin()){  //用户使用该类的任何方法必须已经登录（前置条件）
            $this->error('请先登录！','/Home/UserManager/loginPage',2);
        }
        if(!session(C('SESSION_APP_INFO'))){
            $this->error('请先创建项目！','/Home/ProjectManager/centerPage',2);
        }
    }
    public function batchSend(){
        $this->assignProjectCenterCommonInfo();
        $this->display();
    }

    public function sendList(){
        $this->assignProjectCenterCommonInfo();
        $this->display();
    }
}