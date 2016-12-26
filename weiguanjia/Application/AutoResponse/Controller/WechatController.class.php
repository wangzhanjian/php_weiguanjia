<?php
namespace AutoResponse\Controller;
use Wechat\MsgManager;
use Wechat\VerifyToken;

/**
 * Created by PhpStorm.
 * User: wzj
 * Date: 2016/10/1
 * Time: 18:43
 */
class WechatController
{
    //load files
    protected function load_file(){
        include APP_PATH."AutoResponse/Common/functions.php";
    }

    protected function msgHandle(){
        if(isset($_GET["echostr"])){
            $wechatObj = new VerifyToken();
            $wechatObj->valid();
        }else {
            if (MsgManager::create()) {
                $msgController=new MsgController();
                $msgController->Init();
                $msgController->MsgAutoHandle();
            } else {
                echo "success";
                exit;
            }
        }
    }

    public function appRun(){
        $this->load_file();
        $this->msgHandle();
    }
}