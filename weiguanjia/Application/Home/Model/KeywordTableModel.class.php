<?php
/**
 * Created by PhpStorm.
 * User: ji
 * Date: 2016/12/17
 * Time: 14:59
 */

namespace Home\Model;


use Think\Model;

class KeywordTableModel extends Model
{
    protected $_validate = array(
        //验证字段非空
        array('rule','require','规则名称必须填写！'),
        array('rule','1,30','规则长度为1-30位！',1,'length',3),
        array('keyword','require','关键字不能为空！'),
        array('keyword','1,30','关键字长度为1-30位',1,'length',3),
        array('response_type','require','回复类型不能为空！'),
    );
}