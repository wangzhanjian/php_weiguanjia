<?php
return array(
    // 定义数据库连接信息
    'DB_TYPE'=> 'mysql',// 指定数据库是mysql
    'DB_HOST'=> 'localhost',
    'DB_NAME'=>'wehosting', // 数据库名
    'DB_USER'=>'root',
    'DB_PWD'=>'', //您的数据库连接密码
    'DB_CHARSET'=> 'utf8',// 字符集

    'SESSION_APP_INFO'=>'app_info',     //获取图文消息用的临时session
    'MSG_TPL'=>"./ThinkPHP/Library/Wechat/MsgResponseTpl/",     //消息回复模板
    'TOKEN'=>'weiguanjia'
);