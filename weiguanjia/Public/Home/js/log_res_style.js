$(function () {
    //获取屏幕的宽和高
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
})