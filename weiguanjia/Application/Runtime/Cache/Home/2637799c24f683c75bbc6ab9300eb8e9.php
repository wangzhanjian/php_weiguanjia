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
        <div class="container main_content">
            <div class="row clearfix">
                <div class="col-sm-6 col-md-6 col-lg-6 column left_img">

                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 column">
                        <form role="form" action="/Home/UserManager/register" method="post">
                            <div class="form-group">
                                 <label>用 户 名 <span class="username_tip tip"></span></label>
                                 <input type="text" class="form-control" name="username" id="username" placeholder="请输入邮箱或手机" />
                            </div>
                            <div class="form-group">
                                 <label>密码<span class="password_tip tip"></span></label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="密码由6-16位非空字符组成" />
                            </div>
                            <div class="form-group">
                                 <label>确认密码<span class="affirm_pswd_tip tip"></span></label><input type="password" class="form-control" name="affirm_password" id="affirm_password" />
                            </div>
                            <div class="form-group">
                                 <label>验证码<span class="verify_code_tip tip"></span></label><input type="text" class="form-control verify_code" name="verify_code" id="verify_code" />
                                <div class="verify_code_box">
                                    <img class="verify_img" src="/Home/UserManager/getVerify"/> <a href="" id="change_verify_code"> &nbsp;看不清</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label><input type="checkbox" data-cur="odd" id="agreement" name="agreement" />我已阅读并同意<a href="">《微管家用户注册协议》</a></label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-default disabled btn-block btn-primary" data-type="btn_submit">注册</button>
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
<script type="text/javascript" src="/Public/Home/js/register_verify.js"></script>
</html>