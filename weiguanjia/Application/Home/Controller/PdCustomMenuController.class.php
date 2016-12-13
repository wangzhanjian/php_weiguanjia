<?php
/**
 * Created by PhpStorm.
 * User: ji
 * Date: 2016/11/21
 * Time: 14:53
 */

namespace Home\Controller;


use Think\Controller;
use Wechat\MenuManager;

class PdCustomMenuController extends BasisController
{
    //显示自定义菜单界面
    public function menu(){
        $MenuManager = new MenuManager();
        $menu_decode = json_decode($MenuManager->ViewMenu(),true);
        $menu = $menu_decode["menu"]["button"];
        for ($i = 0;$i<count($menu);$i++)
        {
            if ($menu[$i]["sub_button"] != NULL){
                $menu[$i]["category"] = "list";
                $menu[$i]["type"] = "list";
            }else{
                $menu[$i]["category"] = "botton";
            }
        }
        $this->assign("menu",$menu);
        $this->display();
}

    //创建自定义菜单
    public function create(){
        $menu_json=I();
        $menu = htmlspecialchars_decode(json_encode($menu_json,JSON_UNESCAPED_UNICODE));
        $MenuManager = new MenuManager();
        $MenuManager->CreateMenu($menu);
//        error_log($menu,3,"./log.txt");
        dump($menu);
    }

    //删除自定义菜单
    public function delete(){
        $MenuManager = new MenuManager();
        $json = I();
        $delete = $json["delete"];
        $response = $MenuManager->DeleteMenu();
        error_log($response,3,"./log.txt");
        echo $response;
    }
    //获取自定义菜单
    protected function getMenu(){

    }
}