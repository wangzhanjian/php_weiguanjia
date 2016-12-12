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
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/log_reg.css" />
    </head>
    <body>
        <!--navbar-->
        <div class="row clearfix">
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
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
        <div class="container main_content login">
            <div class="row clearfix">
                <div class="col-sm-6 col-md-6 col-lg-6 column left_img">

                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 column">
                    <form role="form" action="/Home/UserManager/login" method="post">
                        <div class="form-group">
                             <label>用户名</label>
                            <?php if(empty($remember_username)): ?><input type="text" class="form-control" name="username" />
                                <?php else: ?>
                                <input type="text" class="form-control" name="username" value="<?php echo ($remember_username); ?>"  /><?php endif; ?>

                        </div>
                        <div class="form-group">
                             <label>密&nbsp;&nbsp;&nbsp;&nbsp;码</label>
                            <?php if(empty($remember_password)): ?><input type="password" class="form-control" name="password" />
                                <?php else: ?>
                                <input type="password" class="form-control" name="password" value="<?php echo ($remember_password); ?>"/><?php endif; ?>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default btn-primary btn-block">登录</button>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <?php if(empty($remember_password)): ?><label><input type="checkbox" name="remember_password" />记住密码</label>
                                    <?php else: ?>
                                    <label><input type="checkbox" checked="true"  name="remember_password" />记住密码</label><?php endif; ?>
                                <label class="right"><a href="forgetPassword">? 忘记密码</a></label>
                            </div>
                        </div>
                    </form>
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