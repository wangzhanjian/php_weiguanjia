<?php
/**
 * Created by PhpStorm.
 * User: ji
 * Date: 2016/11/21
 * Time: 14:53
 */

namespace Home\Controller;


use Think\Controller;
use Wechat\MaterialManager;
use Wechat\MenuManager;

class PdCustomMenuController extends BasisController
{
    //设置该类使用的前置条件限制 ok
    public function __construct()
    {
        parent::__construct();
        if(!$this->isLogin()){  //用户使用该类的任何方法必须已经登录（前置条件）
            $this->error('请先登录！','/Home/UserManager/loginPage',2);
        }
    }
    //显示自定义菜单界面
    public function menu(){
        $menu = $this->getMenu();
        for ($i = 0;$i<count($menu);$i++)
        {
            if ($menu[$i]["sub_button"] != NULL){
                $menu[$i]["category"] = "list";
                $menu[$i]["type"] = "list";
            }else{
                $menu[$i]["category"] = "button";
            }
        }
        $this->assignProjectCenterCommonInfo();
        $this->assign("menu",$menu);
        $this->display();
    }
    //按照media_id获取素材
    public function getFromId(){
//        $media_id = I();
        $media_id = "QhJW5PvuJhXvjV1NwwVYLaOif3dIFJM36tdhjEUV1kc";
        $get_from_id = new MaterialManager();
        $responce = $get_from_id->getPermanentMaterial($media_id);
        header("Content-type:image/jpeg");
        echo $responce;
    }
    //创建自定义菜单
    public function create(){
        $menu_json=I();
        $menu = htmlspecialchars_decode(json_encode($menu_json,JSON_UNESCAPED_UNICODE));
        $MenuManager = new MenuManager();
        $MenuManager->CreateMenu($menu);
        dump($menu);
    }
    //保存key和其对应的text
    public function saveKeyText(){
        $data_json = I();
        $data = htmlspecialchars_decode(json_encode($data_json,JSON_UNESCAPED_UNICODE));
        $data = json_decode($data,true);
        $app_source_id = session(C("SESSION_APP_INFO"))["app_source_id"];
        $db = M("event_text_response");
        foreach($data as $key=>$val) {
            $result = $db->field("id")->where("app_source_id='%s' and event='click' and key='%d'",$app_source_id,$data[$key]["key"])->select();
            $insert["app_source_id"] = $app_source_id;
            $insert["event"] = "click";
            $insert["event_key"] = $data[$key]["key"];
            $insert["content"] = $data[$key]["text"];
            if ($result == null){
                $db->data($insert)->add();
            }else{
                $db->save($insert);
            }
        }
        echo "success";
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
        $MenuManager = new MenuManager();
        $menu_decode = json_decode($MenuManager->ViewMenu(),true);
        $menu = $menu_decode["menu"]["button"];
        return $menu;
    }
}