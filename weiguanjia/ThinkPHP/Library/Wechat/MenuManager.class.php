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
    //创建菜单 ok
    public function CreateMenu($menuInfo){
        $accessToken=$this->getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$accessToken}";
        $curl=new Curl();
        $curl->post($url,$menuInfo);
        $response = $curl->response;
        $curl->close();
        return $response;
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
    //删除所有菜单 ok
    public function DeleteMenu(){
        $accessToken = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={$accessToken}";
        $curl = new Curl();
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER,0);
        $curl->get($url);
        return $curl->response;
    }
}