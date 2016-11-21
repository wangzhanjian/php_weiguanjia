/* 
* @Author: anchen
* @Date:   2016-11-19 16:20:46
* @Last Modified by:   anchen
* @Last Modified time: 2016-11-19 23:41:48
*/
$(document).ready(function() {
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