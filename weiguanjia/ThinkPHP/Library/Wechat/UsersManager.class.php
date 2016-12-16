<?php
/**
 * Created by PhpStorm.
 * User: 田源
 * Date: 2016/10/6
 * Time: 14:21
 */
namespace Wechat;

use Wechat\AccessToken;
use Curl\Curl;

class UsersManager extends AccessToken
{
    //获取用户列表
    public function userList(){
        $accessToken = $this->getAccessToken();
        $curl = new Curl();
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER,0);
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$accessToken";
        $curl->get($url);
        $response = $curl->response;
        $curl->close();
        return $response;
    }

    //获取用户内容
    public function userInfo($userlist){
        $accessToken = $this->getAccessToken();
        $curl = new Curl();
        $url = "https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token=$accessToken";
        $curl->post($url,$userlist);
        $response = $curl->response;
        $curl->close();
        return $response;
    }

    //获取全部标签
    public function allLabel(){
        $accessToken = $this->getAccessToken();
        $curl = new Curl();
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER,0);
        $url = "https://api.weixin.qq.com/cgi-bin/tags/get?access_token=$accessToken";
        $curl->get($url);
        $response = $curl->response;
        $curl->close();
        return $response;
    }

    //创建标签
    public function createLabel($addlabel){ //输入创建内容
        $accessToken = $this->getAccessToken();
        $curl = new Curl();
        $url = "https://api.weixin.qq.com/cgi-bin/tags/create?access_token=$accessToken";
        $curl->post($url,$addlabel);
        $response = $curl->response;
        $curl->close();
        return $response;
    }

    //编辑标签
    public function updateLabel($updatalabel){
        $accessToken = $this->getAccessToken();
        $curl = new Curl();
        $url = "https://api.weixin.qq.com/cgi-bin/tags/update?access_token=$accessToken";
        $curl->post($url,$updatalabel);
        $response = $curl->response;
        $curl->close();
        return $response;
    }

    //删除标签
    public function deleteLabel($deletelabel){
        $accessToken = $this->getAccessToken();
        $curl = new Curl();
        $url = "https://api.weixin.qq.com/cgi-bin/tags/delete?access_token=$accessToken";
        $curl->post($url,$deletelabel);
        $response = $curl->response;
        $curl->close();
        return $response;
    }

    //标签下粉丝（全部查找、搜索）
    public function getLabelUsers($group){
        $accessToken = $this->getAccessToken();
        $curl = new Curl();
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER,0);
        $url = "https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token=$accessToken";
        $curl->post($url,$group);
        $response = $curl->response;
        $curl->close();
        return $response;
    }

    //批量打标签（批量管理用户，单个用户标签更改）
    public function moreUserLabel($usersmanagement){
        $accessToken = $this->getAccessToken();
        $curl = new Curl();
        $url = "https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token=$accessToken";
        $curl->post($url,$usersmanagement);
        $response = $curl->response;
        $curl->close();
        return $response;
    }
    //批量为用户取消标签
    public function cancelLabels($canceluserlabel){
        $accessToken = $this->getAccessToken();
        $curl = new Curl();
        $url = "https://api.weixin.qq.com/cgi-bin/tags/members/batchuntagging?access_token=$accessToken";
        $curl->post($url,$canceluserlabel);
        $response = $curl->response;
        $curl->close();
        return $response;
    }

    //获取用户身上的标签列表
    public function getUserLabel($userlabel){
        $accessToken = $this->getAccessToken();
        $curl = new Curl();
        $url = "https://api.weixin.qq.com/cgi-bin/tags/getidlist?access_token=$accessToken";
        $curl->post($url,$userlabel);
        $response = $curl->response;
        $curl->close();
        return $response;
    }

    //设置用户备注名
    public function updateNode($note){
        dump($note);
        $accessToken = $this->getAccessToken();
        $curl = new Curl();
        $url = "https://api.weixin.qq.com/cgi-bin/user/info/updateremark?access_token=$accessToken";
        $curl->post($url,$note);
        $response = $curl->response;
        $curl->close();
        return $response;
    }

//    //获取用户地理位置
//    public function getLocation(){
//        //xml数据包
//    }

    //获取黑名单列表
    public function getBlackList($blacklist){
        $accessToken = $this->getAccessToken();
        $curl = new Curl();
        $url = "https://api.weixin.qq.com/cgi-bin/tags/members/getblacklist?access_token=$accessToken";
        $curl->post($url,$blacklist);
        $response = $curl->response;
        $curl->close();
        return $response;
    }

    //拉黑用户
    public function shieldUsers($getblack){
        $accessToken = $this->getAccessToken();
        $curl = new Curl();
        $url = "https://api.weixin.qq.com/cgi-bin/tags/members/batchblacklist?access_token=$accessToken";
        $curl->post($url,$getblack);
        $response = $curl->response;
        $curl->close();
        return $response;
    }

    //取消拉黑用户
    public function undoUsers($undo){
        $accessToken = $this->getAccessToken();
        $curl = new Curl();
        $url = "https://api.weixin.qq.com/cgi-bin/tags/members/batchunblacklist?access_token=$accessToken";
        $curl->post($url,$undo);
        $response = $curl->response;
        $curl->close();
        return $response;
    }
}

?>