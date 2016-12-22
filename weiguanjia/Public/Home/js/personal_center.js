$(function(){
    $('#modify_nickname').click(function () {
        $('#td_nickname').html('<input type=text name=new_nickname value='+$('#td_nickname').text()+'>');
        $(this).text('提交').attr('id','update_nickname').addClass('disabled');
        $('[name=new_nickname]').change(function () {
            $val=$(this).val();
            if($val.length <=10){
                $('#update_nickname').removeClass('disabled').click(function () {
                    $url='updateInfoAjax';
                    $data={"nickname":$val};
                    $.get($url,$data,function (data) {
                        if(data=='success'){
                            $('#td_nickname').html($val);
                            $('#navbar_nickname').text($val);
                            $('#update_nickname').attr('id','modify_nickname').html('<del>&nbsp; 修改 &nbsp;</del>');
                        }else{
                            alert(data);
                        }
                    });
                });
            }else{
                alert('昵称必须在10个字符以内！');
            }
        });
    });

    $time=new Date();
    $('#time').html('<i>'+$time.getFullYear()+' 年 '+($time.getMonth()+1)+' 月 '+$time.getDate()+' 日</i> ');
});