<?php
namespace Wechat;
use Think\Controller;

/**
 * Created by PhpStorm.
 * User: wzj
 * Date: 2016/10/7
 * Time: 15:17
 */
class AccessToken extends Controller
{
    protected $_localAccessToken;

    public function __construct()
    {
        if($tokenJson=session(C('SESSION_APP_INFO'))['access_token']){
            $this->_localAccessToken=json_decode($tokenJson);
        }
    }

    public function getAccessToken(){
        if($this->checkLocalAccessToken()){
            return json_decode($this->readAccessTokenFromSession())->access_token;
        }else{
            return json_decode($this->readAccessTokenFromUrl())->access_token;
        }
    }

    protected function readAccessTokenFromSession(){
        return session(C('SESSION_APP_INFO'))['access_token'];
    }

    protected function readAccessTokenFromUrl(){
        $appId=session(C('SESSION_APP_INFO'))['app_id'];
        $appSecret=session(C('SESSION_APP_INFO'))['app_secret'];
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appId."&secret=".$appSecret;
        $data=(json_decode(file_get_contents($url)));
        $data->get_time=time()-3;
        $data=json_encode($data);
        $project=M('project');
        $project->where(array('user_id'=>session(C('SESSION_USER_ID')),'app_id'=>$appId))->save(array('access_token'=>$data));
        $newAppInfo=$project->where(array('user_id'=>session(C('SESSION_USER_ID')),'app_id'=>$appId))->find();
        session(C('SESSION_APP_INFO'),$newAppInfo);     //更新session最新信息
        return $data;
    }

    protected function checkLocalAccessToken(){
        if($this->_localAccessToken){
            if(isset($this->_localAccessToken->access_token)) {
                $tokenLife = time() - $this->_localAccessToken->get_time;
                if ($tokenLife >= 7200) {
                    return false;
                } else {
                    return true;
                }
            }else{
                return false;
            }
        }
        return false;
    }
}