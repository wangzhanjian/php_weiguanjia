$(function(){
    //获取屏幕的宽和高
    var window_x=window.innerWidth<1200?1200:window.innerWidth;
    var window_y=window.innerHeight<610?610:window.innerHeight;
    //调整各个面板的大小
    $('.container-fluid').css('width',window_x-17);
    $('.bg_wall').css('height',window_y-74);
    $('.nav_blank').css('height',window_y-74);
    $('.show_panel').css('height',window_y-74);
    $('.show_panel').css('padding-top',window_y-74-$('.show_panel').children('.container-fluid').height()-40);
    $('.bottom_bar').css('height',window_y-74);
    $('.bottom_bar').css('padding-top',window_y-74- $('.bottom_bar').children('.content').height()-$('.bottom_bar').children('.index_footer').height()-50);
    //添加页面初始动画
    $('.hid').slideToggle();
    $('.act').children('span').slideToggle(0).slideToggle(1500);
    //添加鼠标滚动时事件
    window.onmousewheel=scrollFunc;
    /*当窗口大小重置时重调页面大小*/
    window.onresize=function(){
        var window_x=window.innerWidth<1200?1200:window.innerWidth;
        var window_y=window.innerHeight<610?610:window.innerHeight;
        $('.container-fluid').css('width',window_x-17);
        $('.bg_wall').css('height',window_y-74);
        $('.nav_blank').css('height',window_y-74);
        $('.show_panel').css('height',window_y-74);
        $('.bottom_bar').css('height',window_y-74);
    }
})
function scrollFunc(e){
    var direct=0;
    e=e || window.event;
    var direct = e.wheelDelta > 0 ? 1 : -1;//1:向上 ,-1:向下
    $id=$('.act').attr('data-id');
    if(direct>0){
        if($id>1){
            $('.act').removeClass('act').addClass('hid').slideToggle(1000);
            $('[data-id='+($id-1)+']').addClass('act').removeClass('hid').slideToggle(1000);
            return false;
        }
    }else{
        if($id<3){
            $('.act').removeClass('act').addClass('hid').slideToggle(1000);
            $('[data-id='+(parseInt($id)+1)+']').addClass('act').removeClass('hid').slideToggle(1000);
            return false;
        }
    }
}