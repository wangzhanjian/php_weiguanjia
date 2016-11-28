<?php
namespace Home\Model;
use Think\Model;

/**
 * Created by PhpStorm.
 * User: ji
 * Date: 2016/11/26
 * Time: 14:57
 */
class ProjectModel extends Model
{
    protected $_validate = array(
        //验证字段非空
        array('app_source_id','require','公众号原始id必须填写！'),
        array('app_source_id',15,'app_source_id长度不正确！',1,'length',3),
        array('app_source_id','','公众号已经存在！',1,'unique',3),
        array('app_name','require','公众号名称必须填写！'),
        array('app_name','3,30','app_name长度为3-30位！',1,'length',3),
        array('app_name','','公众号名称已经存在！',1,'unique',3),
        array('app_id','require','app_id必须填写！'),
        array('app_id',18,'app_id长度不正确！',1,'length',3),
        array('app_id','','公众号已经存在！',1,'unique',3),
        array('app_secret','require','app_secret必须填写！'),
        array('app_secret',32,'app_id长度不正确！',1,'length',3),
        array('token','require','token必须填写！'),
        array('token','3,32','token长度位3-32位！',1,'length',3)
    );
}