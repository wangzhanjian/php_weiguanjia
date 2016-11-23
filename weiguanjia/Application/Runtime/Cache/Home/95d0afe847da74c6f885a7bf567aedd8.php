<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>微管家</title>
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">

    <!-- 可选的Bootstrap主题文件（一般不用引入）
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">-->

    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/Public/Home/css/index.css">
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/log_reg.css" />
    </head>
    <body>
        <!--navbar-->
        <!--navbar-->
<div class="row clearfix">
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 column">
                <div class="logo"></div>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 column">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                </div>
            </div>
            <div class="col-sm-8 col-md-8 col-lg-8 column">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active">
                            <a href="./index.html">首页</a>
                        </li>
                        <li>
                            <a href="./project_center.html">项目中心</a>
                        </li>
                        <li>
                            <a href="#">产品中心</a>
                        </li>
                        <li>
                            <a href="./about_us.html">关于我们</a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="./login.html">登录</a>
                        </li>
                        <li>
                            <a href="./register.html">注册</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>
        <!--content-->
        <div class="container main_content">
            <div class="row clearfix">
                <div class="col-sm-6 col-md-6 col-lg-6 column">
                    <img alt="140x140" src="http://ibootstrap-file.b0.upaiyun.com/lorempixel.com/140/140/default.jpg" />
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 column">
                    <form role="form">
                        <div class="form-group">
                             <label>用户名</label>
                                <input type="text" class="form-control" name="username" id="username"/>
                        </div>
                        <div class="form-group">
                             <label>密&nbsp;&nbsp;&nbsp;&nbsp;码</label>
                                <input type="password" class="form-control" name="password" id="password" />
                        </div>
                        <div class="form-group">
                             <label>验证码</label>
                            <input type="text" class="form-control verify_code" name="verify_code" id="verify_code" />
                            <img class="verify_img" src=""/>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default btn-primary btn-block">登录</button>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" name="remember_password" />记住密码</label><label class="right"><a href="">? 忘记密码</a></label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--footer-->
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