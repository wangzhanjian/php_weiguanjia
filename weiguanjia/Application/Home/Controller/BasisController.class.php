<?php
/**
 * Created by PhpStorm.
 * User: ji
 * Date: 2016/11/24
 * Time: 16:32
 */

namespace Home\Controller;


use Think\Controller;

class BasisController extends Controller
{
    public function checkLogin(){
       if(session('?user_id')) {
           return true;
       }else{
           return false;
       }
    }

    public function assignNickname(){
        $this->assign('nickname',session('nickname'));
    }
}