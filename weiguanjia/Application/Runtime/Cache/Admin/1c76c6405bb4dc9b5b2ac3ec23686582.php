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
            <li><a class="on" href="/php_weiguanjia/weiguanjia/Admin/Index/Index">首页</a></li>
            <li><a href="/php_weiguanjia/weiguanjia/Home/Index/Index" target="_blank">网站首页</a></li>
        </ul>
    </div>
    <div class="top-info-wrap">
        <!--<ul class="top-info-list clearfix">-->
            <!--<li><a href="http://www.jscss.me">管理员</a></li>-->
            <!--<li><a href="http://www.jscss.me">修改密码</a></li>-->
            <!--<li><a href="http://www.jscss.me">退出</a></li>-->
        <!--</ul>-->
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
                    <li><a href="/php_weiguanjia/weiguanjia/Admin/ShufflingImg/Index"><i class="icon-font">&#xe017;</i>轮播图管理</a></li>
                    <li><a href="/php_weiguanjia/weiguanjia/Admin/LatestDynamic/Index"><i class="icon-font">&#xe017;</i>最新动态</a></li>
                    <li><a href="/php_weiguanjia/weiguanjia/Admin/SpecialRecommendation/Index"><i class="icon-font">&#xe017;</i>特色推荐</a></li>
                    <li><a href="/php_weiguanjia/weiguanjia/Admin/ProjectDisplay/Index"><i class="icon-font">&#xe017;</i>项目展示</a></li>
                </ul>
            </li>
            <li>
                <span class="left-nav-label"><i class="icon-font">&#xe018;</i>用户管理</span>
                <ul class="sub-menu">
                    <li><a href="/php_weiguanjia/weiguanjia/Admin/UserGzh/Index"><i class="icon-font">&#xe017;</i>查看用户</a></li>
                    <li><a href="/php_weiguanjia/weiguanjia/Admin/UserGzh/gzhList"><i class="icon-font">&#xe017;</i>查看公众号</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
    <!--/sidebar-->
    <!--main-->
        <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/php_weiguanjia/weiguanjia/Admin/Index/Index">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">轮播图管理</span></div>
        </div>
        <div class="result-wrap">
            <form name="myform" id="myform" method="post" enctype= "multipart/form-data" action="/php_weiguanjia/weiguanjia/Admin/ShufflingImg/add">
                <div class="result-title">
                    <div class="result-list">
                        <a href="#" class="addimg"><i class="icon-font"></i>新增图片</a>
                        <div class="update" style="display: none">
                            <div>

                                    <div>
                                        <label>图片别名</label><input type="text" class="addimg_name" name="img_name" id="img_name">
                                    </div>
                                    <div>
                                        <input type="file" class="addimg_img" name="img_img" id="img_img">
                                    </div>
                                    <div>
                                        <input type="submit" name="submit" value="上传">
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th class="tc" width="5%"><input class="allChoose" name="" type="checkbox"></th>
                            <th>ID</th>
                            <th>图片别名</th>
                            <th>图片预览</th>
                            <th>操作</th>
                        </tr>
                        <!--<tr>-->
                            <!--<td class="tc"><input name="id[]" value="59" type="checkbox"></td>-->
                            <!--<td>-->
                                <!--<input name="ids[]" value="59" type="hidden">-->
                                <!--<input class="common-input sort-input" name="ord[]" value="0" type="text">-->
                            <!--</td>-->
                            <!--<td>59</td>-->
                            <!--<td title="2015中国国际矿业大会组委会会议10月26日下午在津召开"><a target="_blank" href="#" title="2015中国国际矿业大会组委会会议10月26日下午在津召开">2015中国国际</a> …-->
                            <!--</td>-->
                            <!--<td>2016-09-05 21:11:01</td>-->
                            <!--<td>2016-09-06 09:11:01</td>-->
                            <!--<td>-->
                                <!--<a class="link-update" href="#">修改</a>-->
                                <!--<a class="link-del" href="#">删除</a>-->
                            <!--</td>-->
                        <!--</tr>-->
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                    <td class="tc"><input name="<?php echo ($vo["id"]); ?>" value="<?php echo ($vo["id"]); ?>" type="checkbox"></td>
                                    <td><?php echo ($vo["id"]); ?></td>
                                    <td><a target="_blank" href="#"><?php echo ($vo["imgname"]); ?></a></td>
                                    <td><img src='/php_weiguanjia/weiguanjia/Public/<?php echo ($vo["src"]); ?>' width="100px"></td>
                                    <td>
                                        <a class="link-del" href="/php_weiguanjia/weiguanjia/Admin/ShufflingImg/delete?id=<?php echo ($vo["id"]); ?>" name="<?php echo ($vo["id"]); ?>">删除</a>
                                    </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </table>
                    <div class="pagination"><ul>
                            <li><?php echo ($page); ?></li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $('.addimg').on('click',function (event) {
            event.preventDefault();//禁用a标签的默认动作（跳转）
            $('.update').css("display","block");
        })
    </script>

    <!--/main-->
</div>
</body>
</html>