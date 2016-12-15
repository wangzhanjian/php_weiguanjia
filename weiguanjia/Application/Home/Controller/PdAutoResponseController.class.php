<?php
/**
 * Created by PhpStorm.
 * User: ji
 * Date: 2016/11/21
 * Time: 14:37
 */

namespace Home\Controller;


use Wechat\MaterialManager;

class PdAutoResponseController extends BasisController
{
    //显示被添加自动回复设置信息页面 ok
    public function subscribeResponse(){
        $response=M('event_table');
        $map=array(
            'app_source_id'=>session(C('SESSION_APP_INFO'))['app_source_id'],
            'event'=>'subscribe',
            'event_key'=>'wgj_default'
        );
        $info=array();
        $info['type']='event';
        $info['response_type']=$response->where($map)->field('response_type')->find();
        if($info['response_type']['response_type']){
            if($info['response_type']['response_type']=='news'){
                $responseMsg=M('event_'.$info['response_type']['response_type'].'_response');
                $data=$responseMsg->where($map)->find();
                $info['media_id']=$data['media_id'];
                $info['time']=$data['time'];
                $manager= new MaterialManager();
                $info['msg']=json_decode($manager->getPermanentMaterial($info['media_id']),true);
            }else{
                $responseMsg=M('event_'.$info['response_type']['response_type'].'_response');
                $info['msg']=$responseMsg->where($map)->find();
            }
        }else{
            $info['msg']='';
        }
        $this->assign('responseInfo',$info);
        $this->assignProjectCenterCommonInfo();
        $this->display();
    }

    //自动回复设置 ok
    public function setResponse(){
        if(I('post.type')=='keyword'){      //关键字设置
            $this->setKeywordResponse();
        }else{                                  //事件设置
            $this->setEventResponse();
        }
    }

    //被添自动回复删除 ok
    public function delResponse(){
        if(I('post.type')=='keyword'){      //关键字设置
            $this->delKeywordResponse();
        }else{                                  //事件设置
            $this->delEventResponse();
        }
    }

    //显示消息自动回复设置信息页面 ok
    public function msgResponse(){
        $response=M('keyword_table');
        $map=array(
            'app_source_id'=>session(C('SESSION_APP_INFO'))['app_source_id'],
            'rule'=>'wgj_default',
        );
        $info=array();
        $info['type']='message';
        $info['response_type']=$response->where($map)->field('response_type')->find();
        if($info['response_type']['response_type']){
            if($info['response_type']['response_type']=='news'){
                $responseMsg=M($info['response_type']['response_type'].'_response');
                $data=$responseMsg->where($map)->find();
                $info['media_id']=$data['media_id'];
                $info['time']=$data['time'];
                $manager= new MaterialManager();
                $info['msg']=json_decode($manager->getPermanentMaterial($info['media_id']),true);
            }else{
                $responseMsg=M($info['response_type']['response_type'].'_response');
                $info['msg']=$responseMsg->where($map)->find();
            }
        }else{
            $info['msg']='';
        }
        $this->assign('responseInfo',$info);
        $this->assignProjectCenterCommonInfo();
        $this->display('subscribeResponse');
    }

    //显示关键字回复信息页面
    public function keywordResponse(){

    }

    //事件类型消息回复设置 ok
    protected function setEventResponse(){
        $event=M('event_table');
        $data=$event->create();
        $data['app_source_id']=session(C('SESSION_APP_INFO'))['app_source_id'];
        $map=array(
            'app_source_id'=>session(C('SESSION_APP_INFO'))['app_source_id'],
            'event'=>I('post.event'),
            'event_key'=>I('post.event_key')
        );
        //更新事件表
        if($event->where($map)->find()){
            $event->where($map)->save($data);
        }else{
            $event->add($data);
        }
        $response=M('event_'.I('post.response_type').'_response');
        $data=$response->create();
        $data['app_source_id']=session(C('SESSION_APP_INFO'))['app_source_id'];
        //更新事件回复表
        if($response->where($map)->find()){
            $response->where($map)->save($data);
        }else{
            $response->add($data);
        }
    }

    //事件类型消息回复删除 ok
    protected function delEventResponse(){
        $event=M('event_table');
        $map=$event->create();
        $map['app_source_id']=session(C('SESSION_APP_INFO'))['app_source_id'];
        $event->where($map)->delete();
    }

    //关键字类型消息回复设置 ok
    protected function setKeywordResponse(){
        $keyword=M('keyword_table');
        $data=$keyword->create();
        $data['app_source_id']=session(C('SESSION_APP_INFO'))['app_source_id'];
        $map=array(
            'app_source_id'=>session(C('SESSION_APP_INFO'))['app_source_id'],
            'keyword'=>I('post.keyword'),
            'rule'=>I('post.rule')
        );
        //更新关键字表
        if($keyword->where($map)->find()){
            $keyword->where($map)->save($data);
        }else{
            $keyword->add($data);
        }
        $response=M(I('post.response_type').'_response');
        $data=$response->create();
        $data['app_source_id']=session(C('SESSION_APP_INFO'))['app_source_id'];
        //更新事件回复表
        if($response->where($map)->find()){
            $response->where($map)->save($data);
        }else{
            $response->add($data);
        }
    }

    //关键字类型消息自动回复删除 ok
    protected function delKeywordResponse(){
        $keyword=M('keyword_table');
        $map=$keyword->create();
        $map['app_source_id']=session(C('SESSION_APP_INFO'))['app_source_id'];
        $keyword->where($map)->delete();
    }
}