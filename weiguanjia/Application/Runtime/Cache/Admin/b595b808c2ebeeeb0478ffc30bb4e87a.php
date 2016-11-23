<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>酒店后台管理</title>
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/main.css"/>
    <script type="text/javascript" src="/Public/Admin/js/libs/modernizr.min.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/jquery-2.2.3.min.js"></script>
</head>
<div class="topbar-wrap white">
<div class="topbar-inner clearfix">
    <div class="topbar-logo-wrap clearfix">
        <h1 class="topbar-logo none"><a href="index.html" class="navbar-brand">后台管理</a></h1>
        <ul class="navbar-list clearfix">
            <li><a class="on" href="index.html">首页</a></li>
            <li><a href="#" target="_blank">网站首页</a></li>
        </ul>
    </div>
    <div class="top-info-wrap">
        <ul class="top-info-list clearfix">
            <li><a href="http://www.jscss.me">管理员</a></li>
            <li><a href="http://www.jscss.me">修改密码</a></li>
            <li><a href="http://www.jscss.me">退出</a></li>
        </ul>
    </div>
</div>
</div>
<div class="container clearfix">
    <!--sidebar-->
    <div class="sidebar-wrap">
    <div class="sidebar-title">
        <h1>菜单</h1>
    </div>
    <div class="sidebar-content">
        <ul class="sidebar-list">
            <li>
                <span class="left-nav-label"><i class="icon-font">&#xe018;</i>内容管理</span>
                <ul class="sub-menu">
                    <li><a href="/Admin/Newses/newsManager"><i class="icon-font">&#xe017;</i>轮播图管理</a></li>
                    <li><a href="/Admin/Newses/newsManager"><i class="icon-font">&#xe017;</i>最新动态</a></li>
                    <li><a href="/Admin/Newses/newsManager"><i class="icon-font">&#xe017;</i>特色推荐</a></li>
                    <li><a href="/Admin/Newses/newsManager"><i class="icon-font">&#xe017;</i>项目展示</a></li>
                </ul>
            </li>
            <li>
                <span class="left-nav-label"><i class="icon-font">&#xe018;</i>用户管理</span>
                <ul class="sub-menu">
                    <li><a href="/Admin/Newses/newsManager"><i class="icon-font">&#xe017;</i>查看用户</a></li>
                    <li><a href="/Admin/Newses/newsManager"><i class="icon-font">&#xe017;</i>查看公众号</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
    <!--/sidebar-->
    <!--main-->
    <!--/sidebar-->
    <div class="main-wrap">
        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font">&#xe06b;</i><span>欢迎进入微管家管理后台</span></div>
        </div>
        <div class="result-wrap">
            <div class="result-title">
                <h1>快捷操作</h1>
            </div>
            <div class="result-content">
                <div class="short-wrap">
                    <a href="/Admin/Room/allRooms"><i class="icon-font">&#xe001;</i>所有客房</a>
                    <a href="/Admin/Categorys/allCategorys"><i class="icon-font">&#xe048;</i>所有客房分类</a>
                    <a href="/Admin/Newses/allNewses"><i class="icon-font">&#xe001;</i>所有新闻</a>
                    <a href="/Admin/Meetings/allMeetings"><i class="icon-font">&#xe048;</i>所有商务会议</a>
                </div>
            </div>
        </div>
        <div class="result-wrap">
            <div class="result-title">
                <h1>客房状况</h1>
            </div>
            <div class="result-content">
                <ul class="sys-info-list">
                    <li>
                        <label class="res-lab">客房总数</label><span class="res-info">3089</span>
                    </li>
                    <li>
                        <label class="res-lab">当前入住</label><span class="res-info">2388</span>
                    </li>
                    <li>
                        <label class="res-lab">客房余量</label><span class="res-info">701</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="result-wrap">
            <div class="result-title">
                <h1>系统基本信息</h1>
            </div>
            <div class="result-content">
                <ul class="sys-info-list">
                    <li>
                        <label class="res-lab">操作系统</label><span class="res-info">WINNT</span>
                    </li>
                    <li>
                        <label class="res-lab">运行环境</label><span class="res-info">Apache/2.2.21 (Win64) PHP/5.3.10</span>
                    </li>
                    <li>
                        <label class="res-lab">上传附件限制</label><span class="res-info">2M</span>
                    </li>
                    <li>
                        <label class="res-lab">北京时间</label><span class="res-info">2014年3月18日 21:08:24</span>
                    </li>
                    <li>
                        <label class="res-lab">服务器域名/IP</label><span class="res-info">localhost [ 127.0.0.1 ]</span>
                    </li>
                    <li>
                        <label class="res-lab">Host</label><span class="res-info">127.0.0.1</span>
                    </li>
                </ul>
            </div>
        </div>
        
    </div>
<!--/main-->

    <!--/main-->
</div>
</body>
</html>