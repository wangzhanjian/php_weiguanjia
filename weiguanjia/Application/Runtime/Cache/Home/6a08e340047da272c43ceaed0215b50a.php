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
                            <li class="active">
                                <a href="modifyPasswordPage">修改密码</a>
                            </li>
                            <li>
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
                        <form role="form" action="/Home/UserManager/updatePassword" method="post" accept-charset="utf-8">
                                <table>
                                    <tr>
                                        <td class="t_head">旧 &nbsp;密 &nbsp;码</td><td><input type="password" name="old_password" value=""></td>
                                    </tr>
                                    <tr>
                                        <td class="t_head">新 &nbsp;密 &nbsp;码</td><td><input type="password" name="new_password" value=""></td>
                                    </tr>
                                    <tr>
                                        <td class="t_head">确认密码</td><td><input type="password" name="affirm_password" value=""></td>
                                    </tr>
                                    <tr>
                                        <td class="t_head" colspan="2"><button type="submit" class="btn btn-default btn-primary btn-block">修改</button></td><td> </td>
                                    </tr>
                                </table>
                            </form>
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
</html>