<?php
/**
 * Created by PhpStorm.
 * User: ji
 * Date: 2016/11/21
 * Time: 14:57
 */

namespace Home\Controller;


use Think\Controller;

class PdMaterialController extends Controller
{
    //显示图文素材管理页面
    public function news(){

    }

    //新建图文消息
    public function addNews(){

    }

    //显示该图文消息编辑页面
    public function editNews(){

    }

    //更新图文消息
    public function updateNews(){

    }

    //删除某个图文素材
    public function delNews(){

    }

    //显示全部图片素材管理页面
    public function imgListAll(){
//        $app_info = C('app_info');
        $accesstonken = "tjD8XV0eG-UWSAC843vZg5dTqw4mZ35NjddypjzyAsjuuCjleCe5RxjQMJR1VEGM2E0cZZpZBwz5ipAMnoMSz45y3w_dtr11_slHP4zAibn7v-6XIH4nkIUMbq3_VOYeGDWgAGACZS";
        $url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$accesstonken;
        $data = '{
                "type":"image",
                "offset":0,
                "count":20
                }';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0);//过滤头部
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt($curl,CURLOPT_POST,true); // post传输数据
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);// post传输数据
        $responseText = curl_exec($curl);
        dump($responseText);
        $res = json_decode($responseText, true);
        curl_close();
        dump($res);
        $this->assign('list',$res);
        $this->display();
    }

    //按分组显示过滤的图片素材管理页面
    public function imgFilterByGroup(){

    }
    public function addpicture(){
            $file = $_FILES['picture'];
            dump($file);
//            $file['name']=iconv("UTF-8","gb2312", $file['name']);
//            $filePath = __ROOT__.'/Public/uploads/'.$file['name'];//网站根目录地址
//            dump($filePath);
//            dump(move_uploaded_file($file['tmp_name'], $filePath));
            header('Content-type:text/html;charset=utf8');
            $upload = new \Think\Upload();// 实例化上传类
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =     './Public/Home/upload/'; // 设置附件上传根目录
            $upload->autoSub = false;
            // 上传文件
            $info   =   $upload->upload();
            dump($info);
            $filePath = $upload->rootPath.$info["picture"]["savename"];
            dump($filePath);
            if($info){
                //将文件上传至微信服务器
                $accessToken = "W8wrhFcWawpNEMUmBl5hWX6XcBP-94RgJ9YnktZVG7ig-bzCF8ul0_CBRP9bH-C_7DUSgPgM9sUAGYNjCdFEkMW6DVEKMk-r1J-mV5imoeFs4exWtnDp52baH1nCLvEXRCJaAJAHSZ";
                $url="https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=$accessToken&type=image";
                $formData=array(
                    'filename'=>$filePath,
                    'filelengh'=>filesize($filePath),
                    'content-type'=>$info['type']
                );
                $curl = curl_init ($url);//初始化CURL会话
                $timeout = 5;
                $data= array(
                    "media"=>"@{$filePath}",
                    'form-data'=>$formData
                );
                curl_setopt ( $curl, CURLOPT_SAFE_UPLOAD, false);
                curl_setopt ( $curl, CURLOPT_POST, 1 );
                curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
                curl_setopt ( $curl, CURLOPT_CONNECTTIMEOUT, $timeout );
                curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE );
                curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, false );
                curl_setopt ( $curl, CURLOPT_POSTFIELDS, $data );
                $result = curl_exec ($curl);
                dump($result);
            }
    }
    //上传永久图片素材
    public function uploadImg(){

        $this->display();
    }

    //删除永久图片素材（单个）
    public function deleteImg(){

    }

    //删除永久图片素材（批量）
    public function delImgBatch(){

    }

    //重命名图片素材
    public function renameImg(){

    }

    //创建图片分组
    public function createImgGroup(){

    }

    //删除图片分组
    public function delImgGroup(){

    }

    //重命名图片分组
    public function renameImgGroup(){

    }

    //移动图片至某一组（批量）
    public function imgMoveToGroup(){
        
    }

    //显示语音素材管理页面
    public function voice(){

    }
    //新增语音素材
    public function addVoice(){

    }

    //删除语音素材
    public function delVoice(){

    }

    //显示编辑语音素材页面
    public function editVoice(){

    }

    //更新语音素材
    public function updateVoice(){

    }

    //下载语音素材
    public function downloadVoice(){

    }
}