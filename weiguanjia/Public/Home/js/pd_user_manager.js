$(function () {
    /*以下用于index页面*/
    $('.right_content').children('button').click(function () {
        window.location.href=$(this).attr('href');
    });

    $(".label-select").change(function () {
        $label_now = {
            "label":$(this).attr("now-label"),
            "label-now":$(this).find("option:selected").attr("value"),
            "openid":$(this).attr("openid")
        };
        $(this).attr("now-label",$(this).val());
        $.post("changeLabel",$label_now,function (data) {

        })
    })

    $(".label-select").each(function () {
        $(this).val($(this).attr("now-label"));
    })

    $(".save").click(function () {
        $temp=$(this);
        $openid = $(this).parents(".modal").attr("id");
        $remark = $(this).parents(".modal-footer").siblings(".modal-body").find(".remark").val();
        $remark_post = {
            "openid" : $openid,
            "remark" : $remark
        }
        $.post("alias",$remark_post,function (data) {
            $temp.parents('.list_cell').find('h4 span').text('【'+$remark+'】');
        })
    })

    /*以下用于newLabel和labelPage页面*/
    $(".in_group").click(function () {
        $(this).siblings("input").trigger("click");
    })

    $(".del_group").click(function(){
        $(this).parents(".data_box").addClass("active_group");
        $openid = $(this).attr("value");
        $openid_post = {
            "openid" : $openid
        }
        $.post("deleteLabel",$openid_post,function (data) {
            if (data == "ok"){
                alert("删除成功");
                $(".active_group").remove();
            }else
            {
                alert("删除失败");
                $(".active_group").removeClass("active_group");
            }
        })
    })
    $(".del_this_group").click(function () {
        $openid = $(this).attr("group_id");
        $openid_post = {
            "openid" : $openid
        }
        $.post("deleteLabel",$openid_post,function (data) {
            if (data == "ok"){
                alert("删除成功");
                $(".active").trigger("click");
            }else
            {
                alert("删除失败");
            }
        })
    })
    $(".remove_user").click(function () {
        $(this).parents(".label_cell").addClass("active_user");
        $openid = $(this).attr("user_id");
        $tagid = $(this).attr("group_id");
        $data_post = {
            "openid" : $openid,
            "tag_id" : $tagid
        }
        $.post("cancelLabels",$data_post,function (data) {
            if (data == "ok"){
                alert("删除成功");
                $(".active_user").remove();
            }else
            {
                alert("删除失败");
            }
        })
    })
})
function add_black_user_list(ele) {
    $(ele).addClass("active-button");
    $openid = $(ele).parent(".column").prev().find(".label-select").attr("openid");
    $openid_json = {
        "openid":$openid
    }
    $.post("shieldUsers",$openid_json,function (data) {
        console.log(data);
        if (data == "success"){
            $(".active-button").text("取消拉黑用户");
            $(".active-button").attr("onclick","rem_black_user_list(this)");
            $(".active-button").removeClass("active-button");
        }else {
            alert("拉黑失败");
            $(".active-button").removeClass("active-button");
        }
    })
}

function rem_black_user_list(ele) {
    $(ele).addClass("active-button");
    $openid = $(ele).parent(".column").prev().find(".label-select").attr("openid");
    $openid_json = {
        "openid":$openid
    }
    $.post("undoUsers",$openid_json,function (data) {
        if (data == "success"){
            $(".active-button").text("加入黑名单");
            $(".active-button").attr("onclick","add_black_user_list(this)");
            $(".active-button").removeClass("active-button");
        }else {
            alert("取消拉黑失败")
            $(".active-button").removeClass("active-button");
        }
    })
}