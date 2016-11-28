<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>微管家</title>
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/bootstrap.css" />

    <!-- 可选的Bootstrap主题文件（一般不用引入）
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">-->

    <!-- jQuery文件。务必在bootstrap.min.js 之前引入-->
    <script type="text/javascript" src="/Public/Home/js/jquery3.js"></script>
        
    <!-- 最新的 Bootstrap 核心 JavaScript 文件-->
    <script type="text/javascript" src="/Public/Home/js/bootstrap.js"></script>
    <link rel="stylesheet" href="/Public/Home/css/index.css">
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/project_center.css" />
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
                                <a href="/Home/UserManager/info"><span class="glyphicon glyphicon-user"></span><?php echo ($nickname); ?></a>
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
                <div class="col-sm-2 col-md-2 col-lg-2 column left_menu">
                    <ul class="nav">
                        <li>
                            <span class="glyphicon glyphicon-th-large"></span> 功能
                        </li>
                        <li>
                            <a href="">群发功能</a>
                        </li>
                        <li>
                            <a href="">自动回复</a>
                        </li>
                        <li>
                            <a href="">自定义菜单</a>
                        </li>
                         <li>
                            <span class="glyphicon glyphicon-inbox"></span> 管理
                        </li>
                        <li>
                            <a href="">素材管理</a>
                        </li>
                        <li>
                            <a href="">用户管理</a>
                        </li>
                        <li>
                            <a href="">消息管理</a>
                        </li>
                        <li>
                            <span class="glyphicon glyphicon-dashboard"></span> 统计
                        </li>
                        <li>
                            <a href="">用户分析</a>
                        </li>
                        <li>
                            <a href="">图文分析</a>
                        </li>
                        <li>
                            <a href="">菜单分析</a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-10 col-md-10 col-lg-10 column right_content">
                    <ul>
                        <li>
                            Lorem ipsum dolor sit amet
                        </li>
                        <li>
                            Consectetur adipiscing elit
                        </li>
                        <li>
                            Integer molestie lorem at massa
                        </li>
                        <li>
                            Facilisis in pretium nisl aliquet
                        </li>
                        <li>
                            Nulla volutpat aliquam velit
                        </li>
                        <li>
                            Faucibus porta lacus fringilla vel
                        </li>
                        <li>
                            Aenean sit amet erat nunc
                        </li>
                        <li>
                            Eget porttitor lorem
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--hidden nav-->
        <div class="list-group hidden_nav">
            <div>
                <!--唤出隐藏导航栏标签-->
                <a class="right right_label carousel-control" href="#" data-click-count="odd" data-slide="prev"><span class="glyphicon glyphicon-chevron-left glyphicon_left"></span></a>
            </div>
            <label href="#" class="list-group-item active">项目管理</label>
            <a class="list-group-item" id="modal-347417" href="#modal-container-347417" data-toggle="modal">新建项目</a>
            <a href="/Home/ProjectManager/gzhInfo" class="list-group-item">查看公众号</a>
            <div class="dropdown">
            <a href="#" class="list-group-item dropdown-toggle" id="gzh_list" data-toggle="dropdown" aria-expanded="false">
                    切换公众号
            <span class="caret"></span>
            </a>
            <div class="list-group dropdown-menu gzh_list" role="menu" aria-labelledby="gzh_list">
                <?php if(is_array($projectList)): $i = 0; $__LIST__ = $projectList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="#"><?php echo ($vo['app_name']); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                <!--<a class="list-group-item active" role="menuitem" tabindex="-1" href="#">微享PHP</a>-->
                    <!--<a class="list-group-item" role="menuitem" tabindex="-1" href="#">口袋书屋</a>-->
                    <!--<a class="list-group-item" role="menuitem" tabindex="-1" href="#">每日一句</a>-->
                    <!--<a class="list-group-item" role="menuitem" tabindex="-1" href="#">LeisureSquare</a>-->
            </div>
            </div>
        </div>

        <!--create new project-->
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
                                             <label>公众号原始id</label><input type="text" class="form-control" name="app_source_id" id="source_id" />
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
    <script type="text/javascript" src="/Public/Home/js/project_center.js"></script>
</html>