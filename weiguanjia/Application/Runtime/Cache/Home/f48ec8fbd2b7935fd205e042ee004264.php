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
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/project_center.css" />
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
                        <?php if(!empty($nickname)): ?><li>
                                <a href="/Home/UserManager/info"><span class="glyphicon glyphicon-user"></span><span id="navbar_nickname"><?php echo ($nickname); ?></span></a>
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
                <div class="col-sm-2 col-md-2 col-lg-2 col-sm-offset-3 col-md-offset-3 col-lg-offset-3 column left_menu_gzh">
                            <h4><span class="glyphicon glyphicon-phone"></span> 公众号</h4>
                            <ul class="nav">
                                <?php if(is_array($projectList)): $i = 0; $__LIST__ = $projectList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                        <a href=""><?php echo ($vo['app_name']); ?></a>
                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                </div>
                <div class="col-sm-7 col-md-7 col-lg-7 column right_content_gzh">
                    <h3>详情</h3>
                    <p>名称：微享PHP</p>
                    <p>app_id：ASHDFSDA_DASF14/p>
                    <p>app_secreat：<a href="">点击查看</a></p>
                    <p>token：wzj</p>
                    <p>服务器地址：http://www.wangzhanjian.cn/</p>
                    <p>已被托管时间：720天</p>
                    <p>累计被访问次数：10 万次</p>
                    <p>关注量：10 万</p>
                    <p>微享认证状态：已认证</p>
                    <p class="btn_in"><button type="button" class="btn btn-default">开发</button> <button type="button" class="btn btn-default">删除</button></p>
                </div>
            </div>
        </div>

        <!--create new project-->
        <!--新建项目-->
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-12 column">
                    <div class="modal fade" id="modal-container-347417" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="dialog_mask">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="myModalLabel">
                                        请输入项目信息
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form" action="/home/ProjectManager/create" method="post">
                                        <p class="help-block text-right create_help">
                                            <a href="#">如何创建项目？</a>
                                        </p>
                                        <div class="form-group">
                                            <label>公众号原始id</label><input type="text" class="form-control" name="source_id" id="source_id" />
                                        </div>
                                        <div class="form-group">
                                            <label>公众号名称</label><input type="text" class="form-control" name="app_name" id="app_name" />
                                        </div>
                                        <div class="form-group">
                                            <label>app_id</label><input type="text" class="form-control" name="app_id" id="app_id" />
                                        </div>
                                        <div class="form-group">
                                            <label>app_secret</label><input type="text" class="form-control" name="app_secret" id="app_secret" />
                                        </div>
                                        <div class="form-group">
                                            <label>token</label><input type="text" class="form-control" name="token" id="token" />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button> <button type="submit" class="btn btn-primary" id="create">创建</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                        </div>
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