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
    public function createMenu($menuInfo){
        $accessToken=$this->getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$accessToken}";
        $curl=new Curl();
        $curl->post($url,$menuInfo);
        $curl->close();
        return true;
    }

    public function viewMenu(){
        $accessToken=$this->getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$accessToken}";
        $curl=new Curl();
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER,0);
        $curl->get($url);
        return $curl->response;
    }
}