<?php
namespace AutoResponse\Controller;
use Wechat\MaterialManager;
use Wechat\MsgManager;

/**
 * Created by PhpStorm.
 * User: wzj
 * Date: 2016/10/1
 * Time: 17:25
 */
class MsgController
{
    protected $_msgManager;

    public function Init(){
        $this->_msgManager=MsgManager::create();
    }

    //消息自动回复处理 ok
    public function MsgAutoHandle(){
        $msgType=$this->_msgManager->getPostMsgType();
        if($msgType=='text'){               //关键字自动回复
            $msg=$this->_msgManager->getPostMsgToObj();
            $from="$msg->ToUserName";         //回复消息的用户app_source_id
            $keyword="$msg->Content";         //获取关键字
            //查询回复内容
            $this->keywordMsgResponse($from,$keyword);  //关键字消息回复
        }else if($msgType=='event'){        //事件类型消息自动回复
            $msg=$this->_msgManager->getPostMsgToObj();
            $from="$msg->ToUserName";         //回复消息的用户app_source_id
            $event="$msg->Event";             //获取事件
            $event_key="$msg->EventKey";      //获取事件KEY值
            $this->eventMsgResponse($from,$event,$event_key);
        }else{
            echo '';
        }
    }

    //关键字自动回复处理 ok
    protected function keywordMsgResponse($from,$keyword){
        $keyTable=M('keyword_table');
        $map=array(
            'app_source_id'=>$from,
            'keyword'=>$keyword
        );
        $mapDefault=array(
            'app_source_id'=>$from,
            'keyword'=>'wgj_default'
        );
        // 查询关键字信息
        if(!$ruleInfo=$keyTable->where($map)->field(array('rule','response_type'))->find()){
            $ruleInfo=$keyTable->where($mapDefault)->field(array('rule','response_type'))->find();
        }
        if($ruleInfo){      //如果存在该关键字或默认回复信息
            $response=M($ruleInfo['response_type'].'_response');
            //获取关键字对应的回复信息
            $responseMsg=$response->where(array('app_source_id'=>$from,'rule'=>$ruleInfo['rule']))->find();
            switch ($ruleInfo['response_type']){
                case 'text':
                    $this->_msgManager->responseMsg('text',array($responseMsg['content']));
                    break;
                case 'image':
                    $this->_msgManager->responseMsg('image',array($responseMsg['media_id']));
                    break;
                case 'voice':
                    $this->_msgManager->responseMsg('voice',array($responseMsg['media_id']));
                    break;
                case 'music':
                    $data=array(
                        $responseMsg['title'],
                        $responseMsg['description'],
                        $responseMsg['music_url'],
                        $responseMsg['hq_music_url'],
                        $responseMsg['thumb_media_id']
                    );
                    $this->_msgManager->responseMsg('music',$data);
                    break;
                case 'video':
                    $data=array(
                        $responseMsg['media_id'],
                        $responseMsg['title'],
                        $responseMsg['description'],
                    );
                    $this->_msgManager->responseMsg('video',$data);
                    break;
                case 'news':
                    $app=M('project');
                    $appInfo=$app->where(array('app_source_id'=>$from))->find();
                    session(C('SESSION_APP_INFO'),$appInfo);
                    $manager= new MaterialManager();
                    $news=json_decode($manager->getPermanentMaterial($responseMsg['media_id']),true);
                    session('[destroy]');
                    $newsCount=count($news['news_item']);
                    $data=array($newsCount);
                    foreach ($news['news_item'] as $k=>$v){
                        array_push($data,$v['title'],$v['digest'],htmlspecialchars($v['thumb_url']),htmlspecialchars($v['url']));
                    }
                    $this->_msgManager->responseMsg('news',$data);
                    break;
            }
        }else{
            echo '';
        }
    }

    //事件自动回复处理 ok
    protected function eventMsgResponse($from,$event,$eventKey){
        $eventTable=M('event_table');
        if($event=='subscribe'){
            $eventKey='wgj_default';
        }
        $map=array(
            'app_source_id'=>$from,
            'event'=>$event,
            'event_key'=>$eventKey
        );
        $keyInfo=$eventTable->where($map)->field('response_type')->find();
        if($keyInfo){       //如果有该事件的回复信息
            $response=M('event_'.$keyInfo['response_type'].'_response');
            $responseMsg=$response->where($map)->find();
            switch ($keyInfo['response_type']){
                case 'text':
                    $this->_msgManager->responseMsg('text',array($responseMsg['content']));
                    break;
                case 'image':
                    $this->_msgManager->responseMsg('image',array($responseMsg['media_id']));
                    break;
                case 'voice':
                    $this->_msgManager->responseMsg('voice',array($responseMsg['media_id']));
                    break;
                case 'music':
                    $data=array(
                        $responseMsg['title'],
                        $responseMsg['description'],
                        $responseMsg['music_url'],
                        $responseMsg['hq_music_url'],
                        $responseMsg['thumb_media_id']
                    );
                    $this->_msgManager->responseMsg('music',$data);
                    break;
                case 'video':
                    $data=array(
                        $responseMsg['media_id'],
                        $responseMsg['title'],
                        $responseMsg['description'],
                    );
                    $this->_msgManager->responseMsg('video',$data);
                    break;
                case 'news':
                    $app=M('project');
                    $appInfo=$app->where(array('app_source_id'=>$from))->find();
                    session(C('SESSION_APP_INFO'),$appInfo);
                    $manager= new MaterialManager();
                    $news=json_decode($manager->getPermanentMaterial($responseMsg['media_id']),true);
                    session('[destroy]');
                    $newsCount=count($news['news_item']);
                    $data=array($newsCount);
                    foreach ($news['news_item'] as $k=>$v){
                        array_push($data,$v['title'],$v['digest'],htmlspecialchars($v['thumb_url']),htmlspecialchars($v['url']));
                    }
                    $this->_msgManager->responseMsg('news',$data);
                    break;
            }
        }else{
            echo '';
        }
    }

}