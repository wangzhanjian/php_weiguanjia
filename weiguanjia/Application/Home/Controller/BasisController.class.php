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
    public function isLogin(){
       return session('?'.C('SESSION_USER_ID'));
    }

}