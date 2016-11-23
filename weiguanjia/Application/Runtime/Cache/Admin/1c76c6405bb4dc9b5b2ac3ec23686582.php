<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>酒店后台管理</title>
    <link rel="stylesheet" type="text/css" href="/php_weiguanjia/weiguanjia/Public/Admin/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/php_weiguanjia/weiguanjia/Public/Admin/css/main.css"/>
    <script type="text/javascript" src="/php_weiguanjia/weiguanjia/Public/Admin/js/libs/modernizr.min.js"></script>
    <script type="text/javascript" src="/php_weiguanjia/weiguanjia/Public/Admin/js/jquery-2.2.3.min.js"></script>
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
                <a href="#"><i class="icon-font">&#xe018;</i>素材管理</a>
                <ul class="sub-menu">
                    <li><a href="/php_weiguanjia/weiguanjia/Admin/Newses/newsManager"><i class="icon-font">&#xe017;</i>图文消息管理</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
    <!--/sidebar-->
    <!--main-->
        <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="index.html">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">所有商务会议</span></div>
        </div>
        <div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div class="result-title">
                    <div class="result-list">
                        <a href="addNews.html"><i class="icon-font"></i>新增会议</a>
                        <a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>
                        <a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>
                    </div>
                </div>
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th class="tc" width="5%"><input class="allChoose" name="" type="checkbox"></th>
                            <th>排序</th>
                            <th>ID</th>
                            <th>标题</th>
                            <th>发布时间</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        <tr>
                            <td class="tc"><input name="id[]" value="59" type="checkbox"></td>
                            <td>
                                <input name="ids[]" value="59" type="hidden">
                                <input class="common-input sort-input" name="ord[]" value="0" type="text">
                            </td>
                            <td>59</td>
                            <td title="2015中国国际矿业大会组委会会议10月26日下午在津召开"><a target="_blank" href="#" title="2015中国国际矿业大会组委会会议10月26日下午在津召开">2015中国国际</a> …
                            </td>
                            <td>2016-09-05 21:11:01</td>
                            <td>2016-09-06 09:11:01</td>
                            <td>
                                <a class="link-update" href="#">修改</a>
                                <a class="link-del" href="#">删除</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="tc"><input name="id[]" value="59" type="checkbox"></td>
                            <td>
                                <input name="ids[]" value="59" type="hidden">
                                <input class="common-input sort-input" name="ord[]" value="0" type="text">
                            </td>
                            <td>59</td>
                            <td title="2015中国国际矿业大会组委会会议10月26日下午在津召开"><a target="_blank" href="#" title="2015中国国际矿业大会组委会会议10月26日下午在津召开">2015中国国际</a> …
                            </td>
                            <td>2016-09-05 21:11:01</td>
                            <td>2016-09-06 09:11:01</td>
                            <td>
                                <a class="link-update" href="#">修改</a>
                                <a class="link-del" href="#">删除</a>
                            </td>
                        </tr>
                    </table>
                    <div class="list-page"> 2 条 1/1 页</div>
                </div>
            </form>
        </div>
    </div>

    <!--/main-->
</div>
</body>
</html>