<?php
namespace Wechat;
use Curl\Curl;

/**
 * Created by PhpStorm.
 * User: wzj
 * Date: 2016/10/9
 * Time: 20:23
 */
class MenuManager extends AccessToken
{
    //创建菜单
    public function CreateMenu($menuInfo){
        $accessToken=$this->getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$accessToken}";
        $curl=new Curl();
        $curl->post($url,$menuInfo);
        if ($curl->error) {
            error_log($curl->error_message,3,"./log.txt");
        }
        else {
            error_log($curl->response,3,"./log.txt");
        }
        $curl->close();
        return true;
    }
    //查看菜单
    public function ViewMenu(){
        $accessToken=$this->getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$accessToken}";
        $curl=new Curl();
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER,0);
        $curl->get($url);
        return $curl->response;
    }
    //删除所有菜单
    public function DeleteMenu(){
        $accessToken = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={$accessToken}";
        $curl = new Curl();
        $curl->get($url);
        error_log("delete",3,"./log.txt");
        if ($curl->error) {
            error_log($curl->error_message,3,"./log.txt");
        }
        else {
            error_log($curl->response,3,"./log.txt");
        }
        return $curl->response;
    }
}