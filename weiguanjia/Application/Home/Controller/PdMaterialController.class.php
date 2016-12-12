<?php
/**
 * Created by PhpStorm.
 * User: ji
 * Date: 2016/11/21
 * Time: 14:57
 */

namespace Home\Controller;


use Curl\Curl;
use Think\Controller;
use Think\Upload;
use Wechat\AccessToken;
use Wechat\MaterialManager;

class PdMaterialController extends BasisController
{
    //设置该类使用的前置条件限制 ok
    public function __construct()
    {
        parent::__construct();
        if(!$this->isLogin()){  //用户使用该类的任何方法必须已经登录（前置条件）
            $this->error('请先登录！','/Home/UserManager/loginPage',2);
        }
    }

    //显示图文素材管理页面 ok
    public function newsList(){
        $manager=new MaterialManager();
        $list=$manager->getPermanentMaterialList('news',0,20);
        $list=json_decode($list,true);
        $this->assign('list',$list);
        $this->assignProjectCenterCommonInfo();
        $this->display();
    }

    //新建图文消息页面显示 ok
    public function addNewsPage(){
        $this->assignProjectCenterCommonInfo();
        $this->display();
    }

    //新建图文消息ajax接口 ok
    public function addNewsAjax(){
        $manager=new MaterialManager();
        $result=$manager->addPermanentNewsMaterial(htmlspecialchars_decode(json_encode(I('post.'), JSON_UNESCAPED_UNICODE)));
        if(json_decode($result)->error){
            echo 'error';
        }else{
            echo 'success';
        }
    }

    //显示该图文消息编辑页面 ok
    public function editorNews(){
        $manager=new MaterialManager();
        $news=$manager->getPermanentMaterial(I('get.media_id'));
        $this->assign('media_id',I('get.media_id'));
        $this->assign('news',$news);
        $this->assignProjectCenterCommonInfo();
        $this->display();
    }

    //更新图文消息ajax接口 ok
    public function updateNewsAjax(){
        if($this->delete()){    //删除该图文素材
            $this->addNewsAjax();
        }else{      //重新创建该素材
            echo 'error';
        }
    }

    //显示图片素材管理页面 ok
    public function imgList(){
        $manager=new MaterialManager();
        $list=$manager->getPermanentMaterialList('image',0,20);     //获取图片素材列表
        $list=json_decode($list,true);
        $urePrefix='http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl=';
        foreach ($list['item'] as $key=>$val){      //解决图片防盗链问题
            $list['item'][$key]['url']=$urePrefix.$val['url'];
        }
        $this->assign('list',$list);
        $this->assignProjectCenterCommonInfo();
        $this->display();
    }

    //上传永久图片素材 ok
    public function addImage(){
        $upload = new Upload();// 实例化上传类
        $filename=substr($_FILES['files']['name'],0,strrpos($_FILES['files']['name'],'.'));
        $path='./Public/Home/imageBuffer/';
        $upload->exts      =     array('bmp', 'png', 'jif', 'jpeg','jpg');// 设置附件上传类型.
        $upload->maxSize   =    2*1024*1024;
        $upload->rootPath  =   $path; // 设置附件上传根目录
        $upload->autoSub = false;
        $upload->saveName=$filename;
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            echo $upload->getError();
        }else{// 上传本地成功
            $filePath = $_SERVER['DOCUMENT_ROOT'].substr($path.$_FILES['files']['name'],1);
            $manager=new MaterialManager();     //上传到微信
            $result = $manager->addPermanentMaterial($filePath,'image');
            if(isset(json_decode($result)->media_id)){
                unlink($filePath);      //删除缓存文件
                echo $result;
            }else{
                echo 'error';
            }
        }

    }

    //删除永久素材（单个）ok
    public function delete(){
        $manager=new MaterialManager();
        $result=$manager->delPermanentMaterial(I('post.media_id'));
        if(json_decode($result)->errcode==0){
            echo 'success';
            return true;
        }else{
            echo 'error';
            return false;
        }
    }

    //删除永久图片素材（批量）【待实现】
    public function delImgBatch(){

    }

    //显示语音素材管理页面 ok
    public function voiceList(){
        $manager=new MaterialManager();
        $list=$manager->getPermanentMaterialList('voice',0,20);
        $list=json_decode($list,true);
        $this->assign('list',$list);
        $this->assignProjectCenterCommonInfo();
        $this->display();
    }

    //上传语音消息处理 ok
    public function addVoice(){
        $upload = new Upload();// 实例化上传类
        $filename=substr($_FILES['files']['name'],0,strrpos($_FILES['files']['name'],'.'));
        $path='./Public/Home/voiceBuffer/';
        $upload->exts      =     array('mp3', 'wma', 'wav', 'amr');// 设置附件上传类型.
        $upload->maxSize   =    5*1024*1024;
        $upload->rootPath  =   $path; // 设置附件上传根目录
        $upload->autoSub = false;
        $upload->saveName=$filename;
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            echo $upload->getError();
        }else{// 上传本地成功
            $filePath = $_SERVER['DOCUMENT_ROOT'].substr($path.$_FILES['files']['name'],1);
            $manager=new MaterialManager();     //上传到微信
            $result = $manager->addPermanentMaterial($filePath,'voice');
            if(isset(json_decode($result)->media_id)){
                unlink($filePath);      //删除缓存文件
                echo $result;
            }else{
                echo 'error';
            }
        }
    }

    //在线播放语音 ok
    public function voiceDisplay(){
        $manager=new MaterialManager();
        $result=$manager->getPermanentMaterial(I('get.media_id'));
        header('Content-Type: audio/mpeg');
        echo $result;
    }

    //下载语音素材 ok
    public function downloadVoice(){
        $manager=new MaterialManager();
        $result=$manager->getPermanentMaterial(I('get.media_id'));
        if(json_decode($result)->errcode){
            echo $result;
            echo 'failure';
        }else{
            header('Content-Type: application/octet-stream');
            header('Accept-ranges:bytes');
            header('Content-Disposition:attachment;filename='.I('get.file_name'));
            echo $result;
            exit;
        }
    }

    //显示视频素材列表 ok
    public function videoList(){
        $manager=new MaterialManager();
        $list=$manager->getPermanentMaterialList('video',0,20);
        $list=json_decode($list,true);
        $this->assign('list',$list);
        $this->assignProjectCenterCommonInfo();
        $this->display();
    }

    //上传视频操作 ok
    public function addVideo(){
        //dump($_FILES);
        //dump($_POST);
        $upload = new Upload();// 实例化上传类
        $filename=substr($_FILES['files']['name'],0,strrpos($_FILES['files']['name'],'.'));
        $path='./Public/Home/videoBuffer/';
        $upload->exts      =     array('mp4','flv','f4v','webm', 'm4v','mov','3gp','3g2', 'rm','rmvb', 'wmv','avi','asf',
            'mpg','mpeg','mpe','ts','div','dv','divx','vob','dat','mkv','swf','lavf','cpk','dirac','ram','qt','fli','flc',
            'mod');// 设置附件上传类型.
        $upload->maxSize   =    20*1024*1024;
        $upload->rootPath  =   $path; // 设置附件上传根目录
        $upload->autoSub = false;
        $upload->saveName=$filename;
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            echo $upload->getError();
        }else{// 上传本地成功
            $filePath = $_SERVER['DOCUMENT_ROOT'].substr($path.$_FILES['files']['name'],1);
            $manager=new MaterialManager();     //上传到微信
            $result = $manager->addPermanentMaterial($filePath,'video',array('title'=>trim(I('post.title')),'introduction'=>trim(I('post.introduction'))));
            if(isset(json_decode($result)->media_id)){
                unlink($filePath);      //删除缓存文件
                echo $result;
            }else{
                echo 'error';
            }
        }
    }

    //下载视频 error
    public function downloadVideo(){
        $manager=new MaterialManager();
        $result=$manager->getPermanentMaterial(I('post.media_id'));
        if(json_decode($result)->errcode){
            echo $result;
            echo 'failure';
        }else{
            echo $result;
            exit;
        }
    }

    //获取素材列表接口ajax ok
    public function getMaterialListAjax(){
        $manager=new MaterialManager();
        $list=$manager->getPermanentMaterialList(I('get.type'),I('get.offset'),20);
        if(json_decode($list)->error){
            echo 'error';
        }else{
            echo $list;
        }
    }

    //返回语音播放图片 ok
    public function getVoiceDisplayImg(){
        $img=file_get_contents('./Public/Home/images/voice_display.png');
        header('Content-type:image/png');
        echo $img;
    }
}