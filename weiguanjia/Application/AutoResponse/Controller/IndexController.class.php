<?php
namespace AutoResponse\Controller;
use Think\Controller;
use Wechat\MaterialManager;

class IndexController extends Controller {
    public function index(){
        header("Content-type:text/xml;charset=utf8");
        // header("charset=utf8");
        $postStr="<xml>
            <ToUserName><![CDATA[123]]></ToUserName>
            <FromUserName><![CDATA[FromUser]]></FromUserName>
            <CreateTime>123456789</CreateTime>
            <MsgType><![CDATA[event]]></MsgType>
            <Content>你好</Content>
            <Event><![CDATA[subscribe]]></Event>
            </xml>";
        $wechatObj=new WechatController();

        $wechatObj->appRun($postStr);
    }

    public function test(){
        $obj=new MaterialManager();
        $obj->addTemporaryMaterial('../Public/Images/0.jpg','image');

    }
}