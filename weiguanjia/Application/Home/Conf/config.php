<?php
return array(
// 定义数据库连接信息
    'DB_TYPE'=> 'mysql',// 指定数据库是mysql
    'DB_HOST'=> 'localhost',
    'DB_NAME'=>'wehosting', // 数据库名
    'DB_USER'=>'root',
    'DB_PWD'=>'', //您的数据库连接密码
    'DB_CHARSET'=> 'utf8',// 字符集
    'SHOW_PAGE_TRACE' =>true,
    //自定义session信息
    'SESSION_USER_ID'=>'user_id',
    'SESSION_USER_NICKNAME'=>'user_nickname',
    'SESSION_APP_INFO'=>'app_info',
    'SESSION_EMAIL_VERIFY_CODE'=>'email_verify_code'
);