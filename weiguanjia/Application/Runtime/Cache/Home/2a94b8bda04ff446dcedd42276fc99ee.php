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
    </head>
    <body>
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
    <!--轮播图-->
        <div class="row clearfix">
                <div class="col-sm-12 col-md-12 col-lg-12 column">
                    <div class="carousel slide" id="carousel-508571">
                        <ol class="carousel-indicators">
                            <li class="active" data-slide-to="0" data-target="#carousel-508571">
                            </li>
                            <li data-slide-to="1" data-target="#carousel-508571">
                            </li>
                            <li data-slide-to="2" data-target="#carousel-508571">
                            </li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="item active">
                                <img alt="" src=/Public/<?php echo ($shufflingImg[0]['src']); ?> />
                                <div class="carousel-caption">
                                    <h4>
                                        First Thumbnail label
                                    </h4>
                                    <p>
                                        Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
                                    </p>
                                </div>
                            </div>
                            <div class="item">
                                <img alt="" src="/Public/<?php echo ($shufflingImg[1]['src']); ?>" />
                                <div class="carousel-caption">
                                    <h4>
                                        Second Thumbnail label
                                    </h4>
                                    <p>
                                        Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
                                    </p>
                                </div>
                            </div>
                            <div class="item">
                                <img alt="" src="/Public/<?php echo ($shufflingImg[2]['src']); ?>" />
                                <div class="carousel-caption">
                                    <h4>
                                        Third Thumbnail label
                                    </h4>
                                    <p>
                                        Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
                                    </p>
                                </div>
                            </div>
                        </div> <a class="left carousel-control" href="#carousel-508571" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#carousel-508571" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
                    </div>
                </div>
        </div>
    <!--展示区-->
        <div class="container show_panel">
            <div class="row clearfix">
                <div class="col-sm-6 col-md-6 col-lg-6 column">
                    <h4>
                        最新动态<div class="more">
                        <a href="#"><span>>></span>更多</a>
                        </div>
                    </h4>
                    <ul class="list-unstyled nav">
                        <?php if(is_array($latestDynamic)): $i = 0; $__LIST__ = $latestDynamic;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                <a href=""><?php echo ($vo['title']); ?> <span class="time"><?php echo (date("Y-m-d",time($vo['createtime']))); ?></span></a>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>

                    </ul>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 column">
                    <h4>
                        特色推荐<div class="more">
                        <a href="#"><span>>></span>更多</a></div>
                    </h4>
                    <ul class="list-unstyled nav">
                        <?php if(is_array($specialRecommendation)): $i = 0; $__LIST__ = $specialRecommendation;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                <a href=""><?php echo ($vo['title']); ?><span class="time"><?php echo (date("Y-m-d",time($vo['createtime']))); ?></span></a>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>
            <!--<div class="row clearfix">
                <div class="col-sm-12 col-md-12 col-lg-12 column">
                    <h4>
                        项目展示
                    </h4>
                    <ul class="list-unstyled nav">
                        <li>
                            <a href="">Lorem ipsum dolor sit amet</a>
                        </li>
                        <li>
                            <a href="">Consectetur adipiscing elit</a>
                        </li>
                        <li>
                            <a href="">Lorem ipsum dolor sit amet</a>
                        </li>
                        <li>
                            <a href="">Consectetur adipiscing elit</a>
                        </li>
                         <li>
                            <a href="">Consectetur adipiscing elit</a>
                        </li>
                    </ul>
                </div>
            </div>-->
        </div>
        <!--boottom nav-->
        <div class="container bottom_bar">
            <div class="row clearfix">
                <div class="col-xs-3 column">
                        <h4>
                            新手上路
                        </h4>
                        <ul  class="list-unstyled">
                            <li>
                                <a href="">新手指南</a>
                            </li>
                            <li>
                                <a href="">进阶操作</a>
                            </li>
                            <li>
                                <a href="">特色功能</a>
                            </li>
                            <li>
                                <a href="">定制功能</a>
                            </li>
                            <li>
                                <a href="">产品中心</a>
                            </li>
                        </ul>
                    </div>
                <div class="col-xs-3 column">
                        <h4>
                            商务合作
                        </h4>
                        <ul  class="list-unstyled">
                            <li>
                                <a href="">合作优势</a>
                            </li>
                            <li>
                                <a href="">合作入口</a>
                            </li>
                        </ul>
                    </div>
                <div class="col-xs-3 column">
                        <h4>
                            使用帮助
                        </h4>
                        <ul  class="list-unstyled">
                            <li>
                                <a href="">常见问题</a>
                            </li>
                            <li>
                                <a href="">微信规范</a>
                            </li>
                            <li>
                                <a href="">在线咨询</a>
                            </li>
                        </ul>
                    </div>
                <div class="col-xs-3 column">
                        <h4>
                            关于我们
                        </h4>
                        <ul  class="list-unstyled">
                            <li>
                                <a href="">功能介绍</a>
                            </li>
                            <li>
                                <a href="">公司历程</a>
                            </li>
                            <li>
                                <a href="">加入我们</a>
                            </li>
                        </ul>
                    </div>
            </div>
        </div>
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