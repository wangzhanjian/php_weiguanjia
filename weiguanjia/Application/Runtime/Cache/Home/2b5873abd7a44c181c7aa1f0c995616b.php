<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>微管家</title>
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/bootstrap.css" />

    <!-- 可选的Bootstrap主题文件（一般不用引入）
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">-->
    <link rel="stylesheet" href="/Public/Home/css/index.css">
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/personal_center.css" />
        <style type="text/css" media="screen">
            .right_content table td a{
                margin-right: 10px;
            }
        </style>
    </head>
    <body>
    <!--navbar-->
        <div class="row clearfix">
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid top_navbar">
            <div class="col-xs-3 col-sm-3 col-md-2 column">
                <div class="logo"></div>
            </div>
            <div class="col-sm-0 col-md-2 column">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                </div>
            </div>
            <div class="col-sm-9 col-md-8 column">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="/Home">首页</a>
                        </li>
                        <li>
                            <a href="/Home/ProjectManager/centerPage">项目中心</a>
                        </li>
                        <li>
                            <a href="#">产品中心</a>
                        </li>
                        <li>
                            <a href="/Home/Index/aboutUs">关于我们</a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if(!empty($GLOBAL_INFO)): ?><li>
                                <a href="/Home/UserManager/info"><span class="glyphicon glyphicon-user"></span><span id="navbar_nickname"><?php echo ($GLOBAL_INFO['user_nickname']); ?></span></a>
                            </li>
                            <li>
                                <a href="/Home/UserManager/userExit">退出</a>
                            </li>
                            <?php else: ?>
                            <li>
                                <a href="/Home/UserManager/loginPage">登录</a>
                            </li>
                            <li>
                                <a href="/Home/UserManager/registerPage">注册</a>
                            </li><?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>
    <!--content-->
        <div class="container-fluid main_content">
            <div class="row clearfix">
                <div class="col-sm-3 col-md-3 col-lg-3 column">
                    <div class="left_nav">
                       <ul class="nav">
                            <li>
                                <a href="info">个人信息</a>
                            </li>
                            <li>
                                <a href="modifyPasswordPage">修改密码</a>
                            </li>
                            <li class="active">
                                <a href="gzhList">公众号</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 column">
                    <div class="right_content">
                        <div class="date">
                            <span><i>2016 年 11 月 22 日</i></span>
                            <span>梦 &nbsp;很 &nbsp;浅 ，万 &nbsp;物 &nbsp;皆 &nbsp;自 &nbsp;然</span>
                        </div>
                        <div class="content">
                            <table>
                                <?php if(empty($gzh)): ?><td class="t_head"><h4>您还未创建项目</h4></td><td><a href="/Home/ProjectManager/centerPage">去项目中心</a> </td>
                                    <?php else: ?>
                                    <?php if(is_array($gzh)): $i = 0; $__LIST__ = $gzh;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                            <td class="t_head"><?php echo ($vo["app_name"]); ?></td><td><a href="">详 情</a><a href="/Home/ProjectManager/switching?app_name=<?php echo ($vo["app_name"]); ?>">开 发</a><a href="gzhDel?app_name=<?php echo ($vo["app_name"]); ?>">删 除</a></td>
                                        </tr><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!--footer-->
        <div class="row clearfix footer">
    <div class="col-sm-12 col-md-12 col-lg-12 column">
        <p class="text-center">
            Copyright © 2011-2016 www.weiguanjia.com. All Rights Reserved software college of Hebei Normal University
        </p>
        <p class="text-center">冀 ICP 备 2016110.3485A</p>
    </div>
</div>
    </body>
<!-- jQuery文件。务必在bootstrap.min.js 之前引入-->
<script type="text/javascript" src="/Public/Home/js/jquery3.js"></script>
<!-- 最新的 Bootstrap 核心 JavaScript 文件-->
<script type="text/javascript" src="/Public/Home/js/bootstrap.js"></script>
</html>