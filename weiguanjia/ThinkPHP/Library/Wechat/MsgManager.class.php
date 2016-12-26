<?php
namespace Wechat;
/**
 * Created by PhpStorm.
 * User: wzj
 * Date: 2016/9/29
 * Time: 19:52
 * this class used for handle the message that receive and response
 */
class MsgManager
{
    private static $_instance;
    protected $_postObj;

    //create a single instance of class
    public static function create(){
        //get post data, May be due to the different environments
        $postStr =file_get_contents("php://input");
        //extract post data
        if (!empty($postStr)) {
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
               the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            //create single instance
            if(!self::$_instance instanceof self){
                self::$_instance = new self();
                self::$_instance->_postObj=$postObj;
            }
            return self::$_instance;
        }else{
            return false;
        }
    }

    //get post message and return a object
    public function getPostMsgToObj(){
        return $this->_postObj;
    }

    //get post message type
    public function getPostMsgType(){
        return "{$this->_postObj->MsgType}";
    }

    //get the event of event types of messages
    public function getPostMsgEvent(){
        if($this->getPostMsgType()=='event'){
            return "{$this->_postObj->Event}";
        }else{
            echo "this message type is not event!";
            exit;
        }
    }

    //response message to wechat server
    public function responseMsg($msgType,$content){
        $msgTpl = get_tpl_obj($msgType);    //get message template
        //news message handle
        if($msgType == 'news'){
            $itemsNum=$content[0];
            if($itemsNum > 1){
                $addPos=$msgTpl->Articles[0];  //the xml node is added
                $node=$msgTpl->Articles->item[0];  //the xml node is add
                for ($i=1; $i < $itemsNum; $i++) {
                    xml_add_node($addPos,$node);
                }
            }
        }
        //others message handle
        $resultStr = $this->setTplContent($msgTpl,$msgType,$content);
        echo $resultStr;
    }

    //auto set tpl content
    protected function setTplContent($tpl,$type,$content){
        $autoContent=array(
            "{$this->_postObj->FromUserName}", //from username
            "{$this->_postObj->ToUserName}",    //to username
            time(), //create time
            $type,  //message type
        );
        $finalContent=array_merge($autoContent,$content);
        $resultStr=xmlObj_traverse($tpl,$finalContent);
        return $resultStr;
    }
}