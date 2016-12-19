<?php
/**
 * Created by PhpStorm.
 * User: ji
 * Date: 2016/12/17
 * Time: 15:04
 */

namespace Home\Model;


use Think\Model;

class EventTableModel extends Model
{
    protected $_validate = array(
        //验证字段非空
        array('event','require','事件名不能为空！'),
        array('event','1,15','事件名长度为1-15位！',1,'length',3),
        array('event_key','require','event_key不能为空！'),
        array('event_key','1,15','event_key长度为1-15位',1,'length',3),
        array('response_type','require','回复类型不能为空！'),
    );
}