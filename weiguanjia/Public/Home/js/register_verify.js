
    $(function(){
        $('#agreement').click(function(){
            if($(this).attr('data-cur')=='odd'){
                $('[data-type=btn_submit]').removeClass('disabled');
                $(this).attr('data-cur','even');
            }else {
                $('[data-type=btn_submit]').addClass('disabled');
                $(this).attr('data-cur','odd');
            }
        });

        $('#change_verify_code').click(function (e){
            $('.verify_img').attr('src','getVerify');
            e.preventDefault();
            return false;
        });

        $('[name=username]').change(function(){
            if(check_username()){
                $url='checkUserExistAjax';
                $data={"username":$(this).val()};
                $.post($url,$data,function (data) {
                    if(data=='已注册'){
                        $('[name=username]').css('border-color','#f00');
                        $('.username_tip').text('（用户名已被注册！）').css('color','#f00').removeClass('glyphicon glyphicon-ok');
                    }else{
                        $('.username_tip').text('').addClass('glyphicon glyphicon-ok').css('color','#0f0');
                    }
                });
            }
        });
        $('[name=password]').change(function () {
            check_pswd();
        });
        $('[name=affirm_password]').change(function () {
            check_affirm_pswd();
        });
        $('[name=verify_code]').change(function () {
            check_verify_code()
        });

        $('[data-type=btn_submit]').click(function (){
            if(check_username() && check_pswd() && check_affirm_pswd() && check_verify_code() ){

            }else{
                return false;
            }
        });
    })
    
    function check_username() {
        $usernameEle = $('[name=username]');
        $username = $usernameEle.val();
        if($username.length) {
            $usernameEle = $('[name=username]');
            $emailrule = /\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
            $telrule = /^13(\d{9})$|^15(\d{9})$|^189(\d{8})$/;
            $username = $usernameEle.val();
            if ($emailrule.test($username) || $telrule.test($username)) {
                $usernameEle.css('border-color', '#0f0');
                $('.username_tip').text('');
                return true;
            } else {
                $usernameEle.css('border-color', '#f00');
                $('.username_tip').text('（用户名格式不正确！）').css('color','#f00').removeClass('glyphicon glyphicon-ok');
                return false;
            }
        }else{
            return false;
        }
    }

    function check_pswd() {
        $passwordEle=$('[name=password]');
        $password = $passwordEle.val();
        if($password.length) {
            $pswdrule = /\S{6,16}/;
            if ($pswdrule.test($password)) {
                $passwordEle.css('border-color', '#0f0');
                $('.password_tip').text('');
                return true;
            } else {
                $passwordEle.css('border-color', '#f00');
                $('.password_tip').text('（密码格式不正确！）');
                return false;
            }
        }else{
            return false;
        }
    }

    function check_affirm_pswd() {
        $affirmpswdobj=$('[name=affirm_password]');
        $affirm_pswd = $affirmpswdobj.val();
        if($affirm_pswd.length) {
            $pswd = $('[name=password]').val();
            if ($pswd == $affirm_pswd) {
                $affirmpswdobj.css('border-color', '#0f0');
                $('.affirm_pswd_tip').text('');
                return true;
            } else {
                $affirmpswdobj.css('border-color', '#f00');
                $('.affirm_pswd_tip').text('（两次密码不一致！）');
                return false;
            }
        }else{
            return false;
        }
    }

    function check_verify_code() {
        $verifycodeobj=$('[name=verify_code]');
        $val = $verifycodeobj.val();
        if ($val.length) {
            if($val.length!=4){
                $verifycodeobj.css('border-color', '#f00');
                $('.verify_code_tip').text('（验证码必须为四位！）');
                return false;
            }else {
                $verifycodeobj.css('border-color', '#0f0');
                $('.verify_code_tip').text('');
                return true;
            }
        }else{
            return false;
        }
    }
