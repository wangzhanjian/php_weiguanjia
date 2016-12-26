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
    //设置该类使用的前置条件限制 ok
    public function __construct()
    {
        parent::__construct();
        if(!$this->isLogin()){  //用户使用该类的任何方法必须已经登录（前置条件）
            $this->error('请先登录！','/Home/UserManager/loginPage',2);
        }
        if(!session(C('SESSION_APP_INFO'))){
            $this->error('请先创建项目！','/Home/ProjectManager/centerPage',2);
        }
    }

    //显示被添加自动回复设置信息页面 ok
    public function subscribeResponse(){
        $response=D('event_table');
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

    //自动回复删除 ok
    public function delResponse(){
        if(I('post.type')=='keyword'){      //关键字设置
            $this->delKeywordResponse();
        }else{                                  //事件设置
            $this->delEventResponse();
        }
    }

    //显示消息自动回复设置信息页面 ok
    public function msgResponse(){
        $response=D('keyword_table');
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

    //显示关键字回复信息页面 ok
    public function keywordResponse(){
        $keywordTable=D('keyword_table');   //查找所有的规则
        $ruleMap=array('app_source_id'=>session(C('SESSION_APP_INFO'))['app_source_id']);
        $rules=$keywordTable->where($ruleMap)->field(array('rule','response_type'))->distinct('true')->order('id desc')->select();
        //查找关键字
        $responseInfo=array();  //定义回复信息缓存
        //遍历规则，并按规则获取相应的关键字和回复信息
        foreach ($rules as $v){
            if($v['rule']!='wgj_default'){
                $response=$this->getResponseMsgFromRule($v['rule'],$v['response_type']);
                $response['response_type']=$v['response_type'];
                $response['keyword']= $this->getKeywordFromRule($v['rule']);
                array_push($responseInfo,$response);
            }
        }
        $this->assign('responseInfo',$responseInfo);
        $this->assignProjectCenterCommonInfo();
        $this->display();
    }

    //获取规则对应的关键字 ok
    protected function getKeywordFromRule($rule){
        $keywordTable=D('keyword_table');
        $map=array(
            'app_source_id'=>session(C('SESSION_APP_INFO'))['app_source_id'],
            'rule'=>$rule
        );
        return $keywordTable->where($map)->field('keyword')->order('id')->select();
    }

    //获取规则对应的回复信息 ok
    protected function getResponseMsgFromRule($rule,$responseType){
        $response=M($responseType.'_response');
        $map=array(
            'app_source_id'=>session(C('SESSION_APP_INFO'))['app_source_id'],
            'rule'=>$rule
        );
        if($responseType=='news'){      //获取图文信息
            $data=$response->where($map)->find();
            $info['media_id']=$data['media_id'];
            $info['time']=$data['time'];
            $info['rule']=$rule;
            $manager= new MaterialManager();
            $info['msg']=json_decode($manager->getPermanentMaterial($info['media_id']),true);
            return $info;
        }else{
            return $response->where($map)->field(array('id','app_source_id'),true)->find();
        }
    }

    //关键字消息自动回复设置多关键字（用于关键字回复）ajax ok
    public function keywordResponseAutoSet(){
        //判断新的规则是否已经存在
        if(!$this->isExistRule(trim(I('post.rule')))){
            $keywordArr=explode('|',I('post.keyword'));
            $keywordTable=D('keyword_table');
            $map=array(
                'app_source_id'=>session(C('SESSION_APP_INFO'))['app_source_id'],   //用户
                'rule'=>trim(I('post.rule')),   //规则
            );
            //遍历关键字数组，逐条存储关键字
            foreach ($keywordArr as $v){
                $map['keyword']=trim($v);
                //整理数据
                if(!$data=$keywordTable->create()){
                    echo $keywordTable->getError();
                    exit;
                }
                $data['keyword']=trim($v);
                $data['app_source_id']=session(C('SESSION_APP_INFO'))['app_source_id'];
                $keywordTable->add($data);
            }
            //更新信息回复表，存储要回复的信息内容
            $responseType=I('post.response_type');
            $response=M($responseType.'_response');
            $responseInfo=$response->create();
            $responseInfo['rule']=trim(I('post.rule'));
            $responseInfo['app_source_id']=session(C('SESSION_APP_INFO'))['app_source_id'];
            $response->add($responseInfo);
            echo '创建成功！';
        }else{
            echo '该规则已存在，不可重复创建！';
        }
    }

    //判断设置的规则是否已经存在 ok
    public function isExistRule($rule){
        $keywordTable=D('keyword_table');
        $map=array(
            'app_source_id'=>session(C('SESSION_APP_INFO'))['app_source_id'],
            'rule'=>$rule
        );
        return $keywordTable->where($map)->find();
    }

    //事件类型消息回复设置 ok
    protected function setEventResponse(){
        $event=D('event_table');
        if(!$data=$event->create()){
            echo $event->getError();
            exit;
        }
        $data['app_source_id']=session(C('SESSION_APP_INFO'))['app_source_id'];
        $map=array(
            'app_source_id'=>session(C('SESSION_APP_INFO'))['app_source_id'],
            'event'=>I('post.event'),
            'event_key'=>I('post.event_key')
        );
        //更新事件表并删除相应信息回复表中旧的回复信息
        if($oldResponseInfo=$event->where($map)->find()){
            $oldResponse=M('event_'.$oldResponseInfo['response_type'].'_response');
            $oldResponse->where($map)->delete();
            $event->where($map)->save($data);
        }else{
            $event->add($data);
        }
        //更新事件回复表，添加最新的回复信息
        $response=M('event_'.I('post.response_type').'_response');
        $data=$response->create();
        $data['app_source_id']=session(C('SESSION_APP_INFO'))['app_source_id'];
        if($response->where($map)->find()){
            $response->where($map)->save($data);
        }else{
            $response->add($data);
        }
        echo '设置成功！';
    }

    //事件类型消息回复删除 ok
    protected function delEventResponse(){
        $event=D('event_table');
        $map=array(
            'app_source_id'=>session(C('SESSION_APP_INFO'))['app_source_id'],
            'event'=>I('post.event'),
            'event_key'=>I('post.event_key')
        );
        //查找回复的消息类型
        $response=$event->where($map)->find();
        $responseType=$response['response_type'];
        $responseTable=M('event_'.$responseType.'_response');
        if($responseTable->where($map)->delete()){      //删除回复的消息
            $event->where($map)->delete();              //从事件表中删除该事件
        }
        echo '删除成功！';
    }

    //关键字类型消息回复设置单关键字（用于消息自动回复） ok
    protected function setKeywordResponse(){
        $keyword=D('keyword_table');
        if(!$data=$keyword->create()){
            echo $keyword->getError();
            exit;
        }
        $data['app_source_id']=session(C('SESSION_APP_INFO'))['app_source_id'];
        $map=array(
            'app_source_id'=>session(C('SESSION_APP_INFO'))['app_source_id'],
            'keyword'=>I('post.keyword'),
            'rule'=>I('post.rule')
        );
        //更新关键字表并删除旧的回复信息
        if($oldResponseInfo=$keyword->where($map)->find()){
            $keyword->where($map)->save($data);
            $oldResponse=M($oldResponseInfo['response_type'].'_response');
            $oldResponse->where($map)->delete();
        }else{
            $keyword->add($data);
        }
        //更新关键字回复表
        $response=M(I('post.response_type').'_response');
        $data=$response->create();
        $data['app_source_id']=session(C('SESSION_APP_INFO'))['app_source_id'];
        if($response->where($map)->find()){
            $response->where($map)->save($data);
        }else{
            $response->add($data);
        }
        echo '设置成功！';
    }

    //关键字类型消息自动回复删除 ok
    protected function delKeywordResponse(){
        $keyword=D('keyword_table');
        $map=array(
            'app_source_id'=>session(C('SESSION_APP_INFO'))['app_source_id'],
            'rule'=>I('post.rule')
        );
        //查找回复的消息类型
        $response=$keyword->where($map)->find();
        $responseType=$response['response_type'];
        $responseTable=M($responseType.'_response');
        if($responseTable->where($map)->delete()){      //删除回复的消息
            $keyword->where($map)->delete();             //从事件表中删除该关键字
        }
        echo '删除成功！';
    }

}