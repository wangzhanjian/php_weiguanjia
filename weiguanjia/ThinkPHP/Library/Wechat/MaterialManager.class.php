<?php
namespace Wechat;
use Curl\Curl;
/**
 * Created by PhpStorm.
 * Author: wzj
 * Date: 2016/10/7
 * Time: 16:35
 * directions:all the data function's return is the source data of Wechat,yet the data's type is json
 */

class MaterialManager extends AccessToken
{
    //新增临时素材 ok
    /**
     * @param string $filePath file path
     * @param string $type file type
     * @return string response from wechat server
     */
    public function addTemporaryMaterial($filePath,$type){
        $accessToken=$this->getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$accessToken}&type={$type}";
        $curl=new Curl();
        $file=curl_file_create($filePath);
        $curl->post($url,array(
            "media"=>$file,
        ));
        return $curl->response;
    }

    //获取临时素材 ok
    /**
     * @param string $mediaId material's media_id
     * @return string response from wechat server
     */
    public function saveTemporaryMaterial($mediaId){
        $accessToken=$this->getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/media/get?access_token={$accessToken}&media_id={$mediaId}";
        $curl=new Curl();
        $curl->get($url);
        return $curl->response;
    }

    //新增永久素材 ok
    /**
     * @param string $filePath file path
     * @param string $type file type
     * @param array $videoDescription video description format array('title'=>'value1','introduction'=>'value2')
     * @return string response from wechat server
     */
    public function addPermanentMaterial($filePath,$type,$videoDescription=null){
        if($type != 'video'){
            return $this->addPermanentCommonMaterial($filePath,$type);
        }else{
            return $this->addPermanentVideoMaterial($filePath,$type,$videoDescription);
        }
    }

    //新增永久图文素材 ok
    /**
     * @param string $news news contents json string
     * @return string response from wechat server
     */
    public function addPermanentNewsMaterial($news){
        $accessToken=$this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/material/add_news?access_token={$accessToken}";
        $curl=new Curl();
        $curl->post($url,$news);
        return $curl->response;
    }

    //上传图文消息内容中图片获取相应url ok
    /**
     * @param string $imgPath image path
     * @return string picture url
     */
    public function getNewsImageUrl($imgPath){
        $accessToken=$this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token={$accessToken}";
        $curl=new Curl();
        $file=curl_file_create($imgPath);
        $curl->post($url,array(
            "media"=>$file,
        ));
        return $curl->response;
    }

    //删除永久素材 ok
    /**
     * @param string $mediaId material's media_id
     * @return string response from wechat server
     */
    public function delPermanentMaterial($mediaId){
        $accessToken=$this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/material/del_material?access_token={$accessToken}";
        $curl=new Curl();
        $curl->post($url,'{"media_id":"'.$mediaId.'"}');
        return $curl->response;
    }

    //获取永久素材 ok
    /**
     * @param string $mediaId material's media_id
     * @return string response from wechat server
     */
    public function getPermanentMaterial($mediaId){
        $accessToken=$this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/material/get_material?access_token={$accessToken}";
        $curl=new Curl();
        $curl->post($url,'{"media_id":"'.$mediaId.'"}');
        return $curl->response;
    }

    //获取永久素材列表 ok
    /**
     * @param string $type material type
     * @param integer $offset the starting of material list starting from 0
     * @param integer $count the number of material between 1 and 20
     * @return string response from wechat server
     */
    public function getPermanentMaterialList($type,$offset,$count){
        $accessToken=$this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token={$accessToken}";
        $curl=new Curl();
        $curl->post($url,'{"type":"'.$type.'","offset":'.$offset.',"count":'.$count.'}');
        return $curl->response;
    }

    //修改永久图文素材
    /**
     * @param string $mediaId material media_id
     * @param integer $index the index of material which you want to modify starting from 0
     * @param string $articles articles contents json string
     * @return string response from wechat server
     */
    public function modifyPermanentNewsMaterial($mediaId,$index,$articles){
        $accessToken=$this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/material/update_news?access_token={$accessToken}";
        $curl=new Curl();
        $curl->post($url,'{
        "media_id":"'.$mediaId.'",
        "index":'.$index.',
        "articles":'.$articles.'
        }');
        return $curl->response;
    }

    //获取永久素材总数 ok
    /**
     * @return string response from wechat server
     */
    public function getPermanentMaterialNum(){
        $accessToken=$this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token={$accessToken}";
        $curl=new Curl();
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER,0);
        $curl->get($url);
        return $curl->response;
    }

    //上传永久素材【非视频】ok
    /**
     * @param string $filePath file path
     * @param string $type file type
     * @return string response from wechat server
     */
    protected function addPermanentCommonMaterial($filePath,$type){
        $accessToken=$this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token={$accessToken}&type={$type}";
        $curl=new Curl();
        $file=curl_file_create($filePath);
        $curl->postFile($url,array(
            "media"=>$file,
        ));
       return $curl->response;
    }

    //上传永久素材【视频】 ok
    /**
     * @param string $filePath
     * @param string $type file type
     * @param string $videoDescription video description format array('title'=>'value1','introduction'=>'value2')
     * @return string response from wechat server
     */
    protected function addPermanentVideoMaterial($filePath,$type,$videoDescription){
        $accessToken=$this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token={$accessToken}&type={$type}";
        $curl=new Curl();
        $file=curl_file_create($filePath);
        $curl->postFile($url,array(
            "media"=>$file,
            'description'=>json_encode($videoDescription)
        ));
        return $curl->response;
    }

}