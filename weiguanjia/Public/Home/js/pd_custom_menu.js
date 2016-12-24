/**
 * Created by 天昊 on 2016/12/13.
 */
$keys = Array();
$(document).ready(function() {
    //选中第一个菜单
    $(".pre_menu_list").children(".main_menu:first").addClass("menu_button_select");
    if ($(".menu_button_select").find(".menu_childlist_li").length > 1){
        $(".menu_button_select").find(".menu_childlist_li:first").addClass("active_menu");
    }else {
        $(".menu_button_select").addClass("active_menu");
    }
    $(".menu_button_select").children(".menu_childlist").addClass("child_select");
    $(".global_info").text($(".active_menu").children("a").children("span").text());
    //加载成功时右边的菜单名的显示
    var title = $(".active_menu").children(".menu_link").children(".menu_button").html();
    if (title == null) {
        $(".global_mod").add(".menu_form_bd").css("display", "none");
    }
    $(".js_menu_name").val(title);
    //判断是否显示添加主菜单
    if ($(".pre_menu_list").children(".main_menu").length < 3) {
        $(".add_main_menu").css("display", "block");
    }
    ;
    //根据默认点击的菜单判断菜单编辑区显示的内容
    var default_menu_class = $(".active_menu").children(".menu_link").attr('class');
    if (default_menu_class != null) {
        if (default_menu_class.indexOf("button") != -1) {
            $(".tips_global").css("display", "none");
            $(".menu_content").css("display", "block");
            $(".tabbable").css("display", "block");
        } else {
            $(".tips_global").css("display", "block");
            $(".menu_content").css("display", "none");
            $(".tabbable").css("display", "none");
        }
    }
    //根据默认点击的菜单的菜单类型显示对应内容（未完成）
    var default_menu_type = $(".active_menu").children(".menu_link").attr("active_type");
    $(".select_menu_active").val(default_menu_type);
    switch (default_menu_type) {
        case "view":
            $(".view").find("#urlText").val($(".menu_button_select").children(".menu_link").attr("message"));
            break;
        case "click":
            $(".click").find(".textarea").val($(".menu_button_select").children(".menu_link").attr("text"));
    }
    $(".menu_response").addClass("hidden");
    $('.' + default_menu_type).removeClass("hidden").css("display", "block");
    //获取当前菜单中所有的kay值
    $(".click").each(function () {
        $keys.push($(this).attr("message"));
    })
    //当用户点击菜单时修改菜单的样式类，显示菜单
    $('.pre_menu_list').on("click", '.main_menu', function () {
        //当用户点击一级菜单时
        $(this).addClass("menu_button_select");
        var elsebutton = $('.menu_list').not($(this));
        //获取未被选择的一级菜单
        $(elsebutton).removeClass("menu_button_select");
        $(this).children(".menu_childlist").addClass("child_select");
        $(elsebutton).children(".menu_childlist").removeClass("child_select");
    })
    //添加子菜单
    $(".pre_menu_list").on("click", ".add_menu", function () {
        var count = $(this).siblings(".menu_childlist_li").length;
        console.log(count);
        if (count >= 5) {
            $("#mymodal").modal("toggle");
        } else {
            $(this).before("<li class='menu_childlist_li child_menu'><a href='javascript:void(0)' class='menu_link button menu' active_type='text'><span class='menu_button child_button'>新建菜单</span></a></li>");
            $(this).parents(".menu_list").children(".menu_link.button.menu").attr("class", "menu_link list menu").trigger("click");
            $(".global_info").text("新建菜单");
            $(".js_menu_name").val("新建菜单");
        }
    })
    //添加主菜单
    $(".add_main_menu").click(function () {
        $(this).before("<li class='menu_list main_menu'><a href='javascript:void(0);' class='menu_link button menu'><span class='menu_button'>新建菜单</span></a><div class='menu_childlist'><ul class='menu_childlist_ul'><li class='menu_childlist_li'><a href='javascript:void(0)' class='menu_link add_menu'><span class='menu_button'>+</span></a></li></ul></div></li>");
        if ($(".pre_menu_list").children(".main_menu").length >= 3) {
            $(".add_main_menu").css("display", "none");
        }
        ;
    })
    //点击菜单时在右侧编辑区显示当前菜单名称
    $(".pre_menu_list").on('click', '.menu', function () {
        $(".global_mod").add(".menu_form_bd").css("display", "block");
        var title = $(this).find("span").text();
        $(this).parent("li").addClass("active_menu");
        $(".menu_list").not($(this).parent("li")).removeClass("active_menu");
        $(".menu_childlist_li").not($(this).parent("li")).removeClass("active_menu");
        $(".global_info").text(title);
        $(".js_menu_name").val(title);
    })
    //点击菜单时右侧动作区显示对应动作
    $(".pre_menu_list").on('click', '.menu', function () {
        var type = $(this).attr("active_type");
        $(".select_menu_active").val(type);
        $(".menu_response").addClass("hidden");
        $('.' + type).removeClass("hidden").css("display", "block");
    })
    //当点击有子菜单的主菜单时右侧只显示名称
    $(".pre_menu_list").on('click', '.list', function () {
        $(".tips_global").css("display", "block");
        $(".menu_content").css("display", "none");
        $(".tabbable").css("display", "none");
        $(".menu_response").css("display", "none");
    })
    //当点击子菜单或者无子菜单的主菜单时显示动作选择
    $(".pre_menu_list").on('click', '.button', function () {
        $(".tips_global").css("display", "none");
        $(".menu_content").css("display", "block");
        $(".tabbable").css("display", "block");
        $active_type = $(this).attr("active_type");
        switch ($active_type) {
            case "view":
                $(".view").find("#urlText").val($(this).attr("message"));
        }
    })
    //判断菜单名称长度
    $(".js_menu_name").keyup(function () {
        var str = $(this).val();
        var len = 0;
        for (var i = 0; i < str.length; i++) {
            if (str[i].match(/[^\x00-\xff]/ig) != null) //全角
                len += 2;
            else
                len += 1;
        }
        if (len > 8) {
            $(".js_titleEorTips").css("display", "block");
            $(".js_titleNolTips").css("display", "none");
            $(this).css("border-color", "red");
        } else {
            if (len == 0) {
                $(".js_titlenoTips").css("display", "block");
                $(".js_titleNolTips").css("display", "none");
                $(this).css("border-color", "red");
            } else {
                $(".dn").css("display", "none");
                $(".js_titleNolTips").css("display", "block");
                $(this).css("border-color", "#e7e7eb");
                $(".active_menu").children("a").children("span").text(str);
            }
        }
        ;
    })
    //删除菜单操作
    $("#jsDelBt").click(function () {
        var last = $(".active_menu").siblings(".add_menu");
        $("li").remove(".active_menu");
        if ($(".pre_menu_list").children(".main_menu").length < 3) {
            $(".add_main_menu").css("display", "block");
        }
        ;
        if (last.siblings().length == 0) {
            last.parents(".menu_list").children(".menu_link.list.menu").attr("class", "menu_link button menu");
            last.parents(".menu_list").addClass("active_menu");
            last.parents(".menu_list").children(".menu_link").trigger("click");
        }
        if (last.siblings().size != 0) {
            last.siblings('.menu_childlist_li:eq(0)').children(".menu_link").trigger("click");
            console.log(last.siblings('.menu_childlist_li:eq(0)').text());
        }
    })
    //根据选择修改右侧回复区的内容
    $(".select_menu_active").change(function () {
        var checkValue = $(this).val();
        console.log(checkValue);
        $(".active_menu").children("a").attr("active_type", checkValue);
        $(".menu_response").addClass("hidden");
        $('.' + checkValue).removeClass("hidden").css("display", "block");
    })
    //删除所有菜单
    $(".delete").click(function () {
        $delete = new Object();
        $delete['0'] = "delete";
        $.post('__ROOT__/Home/PdCustomMenu/delete', $delete, function (data) {
            console.log(data);
        })
    })
    //跳转链接的输入框失去焦点时将内容保存到view的div里面
    $("#urlText").blur(function () {
        $(this).parents(".view").attr("message", $(this).val());
    })
    //文本回复的文本域失去焦点时将内容保存click的div里面
    $(".textarea").blur(function () {
        $text = $(this).val();
        $key = Math.max($keys);
        if ($key < 14){
            $keys[$key+1] = $key+1;
            $(".click").attr("message",$key+1);
        }else
        {
            for ($i = 0;$i < 14;$i++){
                if ($keys[$i] == null){
                    $keys[$i] = $i;
                    $(".click").attr("message",$i);
                }
            }
        }
        $(".click").attr("text",$text);
    })
    //当多媒体选择完成点击确定时将多媒体类型和内容保存到media的div里面
    $(".determine").click(function () {
        //获取内容
        $media_id = $(this).parents(".modal-content").find(".column[data-selected='selected']").find("img").attr("data-id");
        //保存类型
        $media_type = $(".nav-tabs").find(".active").attr("media_type");
        $(".media_id").attr("media_type",$(".nav-tabs").find(".active").attr("media_type"));
        //保存内容
        $(".media_id").attr("message", $media_id);
    })
    //当图文选择完成点击确定时将图文信息的media_id保存到view_limited的div里面
    $(".news-select").click(function () {
        //获取内容
        $media_id = $(this).parents(".modal-content").find(".column[data-selected='selected']").find("news-footer").attr("data-id");
        //保存内容
        $(".view_limited").attr("message", $media_id);
    })
    //当点击保存时，将扫一扫工具的key保存到scancode_push的div里面
    $(".open").click(function () {
        $key = Math.max($keys);
        if ($key < 14){
            $keys[$key+1] = $key+1;
            $(".scancode_push").attr("message",$key+1);
        }else
        {
            for ($i = 0;$i < 14;$i++){
                if ($keys[$i] == null){
                    $keys[$i] = $i;
                    $(".scancode_push").attr("message",$i);
                }
            }
        }
    })
    //当点击并非正在编辑的标签或提交按钮时，保存当前标签的修改
    function save_menu() {
        //获取内容
        var mes = $(".menu_response:not('.hidden')").attr("message");
        //将内容保存到选中中的a标签
        $(".active_menu").children("a").attr("message", mes);
        //如果是media_类型的按钮，保存数据类型
        if ($(".active_menu").children("a").attr("active_type") == "media_id") {
            var media_type = $(".menu_response:not('.hidden')").attr("media_type");
            $(".active_menu").children("a").attr("media_type", media_type);
        }
        //如果是click类型的按钮，保存内容
        if ($(".active_menu").children("a").attr("active_type") == "click"){
            $text = $(".menu_response:not('.hidden')").attr("text");
            $(".active_menu").children("a").attr("text", $text);
        }
    }
    $(".pre_menu_list").on("click",$("li").not($(".active_menu")),function () {
        save_menu();
    })
    $(".update").click(function () {
        save_menu();
    })
    //组成json串并上传(新增bug待调试)
    $(".update").click(function () {
        //定义菜单菜单对象
        $menu = new Object();
        $n = 0;
        $menu['button'] = Array();
        //定义保存文本回复的对象
        $text = new Object();
        $c = 0;
        $(".main_menu").each(function () {
            if ($(this).children("a").attr("class").indexOf("button") != -1) {
                //无子菜单的主菜单
                $name = $(this).children("a").text();
                $button_type = $(this).children("a").attr("active_type");
                $message = $(this).children("a").attr("message");
                switch ($button_type) {
                    case "click":
                        $menu['button'][$n] = {
                            "type": "click",
                            "name": $name,
                            "key": $message,
                        }
                        $text[$c] = {
                            "key" : $message,
                            "text" : $(this).children("a").attr("text")
                        }
                        $c++
                        break;
                    case "media_id":
                        $menu['button'][$n] = {
                            "type": $button_type,
                            "name": $name,
                            "media_id": $message,
                            "media_type":$(this).children("a").attr("media_type")
                        };
                        break;
                    case "view_limited":
                        $menu['button'][$n] = {
                            "type": $button_type,
                            "name": $name,
                            "media_id": $message
                        };
                        break;
                    case "view":
                        $menu['button'][$n] = {
                            "type": $button_type,
                            "name": $name,
                            "url": $message
                        };
                        break;
                    case "scancode_push":
                        $menu['button'][$n] = {
                            "type":$button_type,
                            "name":$name,
                            "key":$message
                        }
                        break;
                }
            } else if ($(this).children("a").attr("class").indexOf("button") == -1) {
                $name = $(this).children("a").text();
                $menu['button'][$n] = {
                    "name": $name,
                    "sub_button": Array()
                }
                $i = 0;
                $(this).children(".menu_childlist").children(".menu_childlist_ul").find(".child_menu").each(function () {
                    //有子菜单的主菜单
                    $name = $(this).children("a").text();
                    $button_type = $(this).children("a").attr("active_type");
                    $message = $(this).children("a").attr("message");
                    switch ($button_type) {
                        case "click":
                            $menu['button'][$n]['sub_button'][$i] = {
                                "type": $button_type,
                                "name": $name,
                                "key": $message
                            };
                            $text[$c] = {
                                "key" : $message,
                                "text" : $(this).children("a").attr("text")
                            }
                            $c++
                            break;
                        case "media_id":
                            $menu['button'][$n]['sub_button'][$i] = {
                                "type": $button_type,
                                "name": $name,
                                "media_id": $message
                            };
                            break;
                        case "view_limited":
                            $menu['button'][$n]['sub_button'][$i] = {
                                "type": $button_type,
                                "name": $name,
                                "media_id": $message
                            };
                            break;
                        case "view":
                            $menu['button'][$n]['sub_button'][$i] = {
                                "type": $button_type,
                                "name": $name,
                                "url": $message
                            };
                            break;
                        case "scancode_push":
                            $menu['button'][$n] = {
                                "type":$button_type,
                                "name":$name,
                                "key":$message
                            }
                            break;
                    }
                    $i = $i + 1;
                })
            }
            $n = $n + 1;
        })
        // $.post('saveKeyText',$text , function (data) {
        //     console.log(data);
        // });
        $.post('create', $menu, function (data) {
            if (data == "ok"){
                $("#create_success").modal("toggle");
            }
        });
    })
})