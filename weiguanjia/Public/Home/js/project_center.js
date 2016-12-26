/* 
* @Author: anchen
* @Date:   2016-11-19 16:20:46
* @Last Modified by:   anchen
* @Last Modified time: 2016-11-19 23:41:48
*/
$(document).ready(function() {
    var window_x=window.innerWidth<1200?1200:window.innerWidth;
    var window_y=window.innerHeight<610?610:window.innerHeight;
    $('.container-fluid').css('width',window_x-17);
    if($('.main_content').height()<(window_y-169)){
        $padding_y=(window_y-169-$('.main_content').height())/2>30?(window_y-169-$('.main_content').height())/2:30;
        if($padding_y>30){
            $('.main_content').css({'height':window_y-169,'padding':$padding_y+'px 5%'});
        }else {
            $('.main_content').css('padding','30px 5%');
        }
    }else{
        $('.main_content').css('padding','30px 5%');
    }
    window.onresize=function(){
        var window_x=window.innerWidth<1200?1200:window.innerWidth;
        var window_y=window.innerHeight<610?610:window.innerHeight;
        $('.container-fluid').css('width',window_x-17);
        if($('.main_content').height()<(window_y-169)){
            $padding_y=(window_y-169-$('.main_content').height())/2>30?(window_y-169-$('.main_content').height())/2:30;
            if($padding_y>30){
                $('.main_content').css({'height':window_y-169,'padding':$padding_y+'px 5%'});
            }else {
                $('.main_content').css('padding','30px 5%');
            }
        }else{
            $('.main_content').css('padding','30px 5%');
        }
    }

    $('.left_menu').css('height',$('.left_menu').parent().height());
    $(".right_label").click(function(){
        if($(this).attr('data-click-count') === 'odd'){
            $(this).attr('data-click-count', 'even');
            slide_left('.right_label',0,15);
            slide_left('.hidden_nav',-15,0);
            $(".glyphicon_left").addClass('glyphicon-chevron-right');
        }else{
            $(this).attr('data-click-count', 'odd');
            slide_right('.hidden_nav',0,-15);
            slide_right('.right_label',15,0);
            $(".glyphicon_left").removeClass('glyphicon-chevron-right');
        }
    });
});
    function slide_left(element, pos_s, pos_d){
        $(element).css("right",pos_s+'%');
        if(pos_s < pos_d){
            pos_s+=1;
            setTimeout("slide_left('"+element+"',"+pos_s+","+pos_d+")",10);
        }
    }

    function slide_right(element, pos_s, pos_d){
        $(element).css("right",pos_s+'%');
        if(pos_s > pos_d){
            pos_s-=1;
            setTimeout("slide_right('"+element+"',"+pos_s+","+pos_d+")",10);
        }
    }