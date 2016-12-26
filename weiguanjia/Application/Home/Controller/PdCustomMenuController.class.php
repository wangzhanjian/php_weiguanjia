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
        if(!session(C('SESSION_APP_INFO'))){
            $this->error('请先创建项目！','/Home/ProjectManager/centerPage',2);
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
        $media_id = "QhJW5PvuJhXvjV1NwwVYLaOif3dIFJM36tdhjEUV1kc";
        $get_from_id = new MaterialManager();
        $responce = $get_from_id->getPermanentMaterial($media_id);
        header("Content-type:image/jpeg");
        echo $responce;
    }

    //创建自定义菜单 ok
    public function create(){
        $menu_json=I();
        $menu = htmlspecialchars_decode(json_encode($menu_json,JSON_UNESCAPED_UNICODE));
        dump($menu);
        $MenuManager = new MenuManager();
        $result=$MenuManager->CreateMenu($menu);
        echo $result;
    }

    //保存key和其对应的text
    public function saveKeyText(){
        $data = I();
        $app_source_id = session(C("SESSION_APP_INFO"))["app_source_id"];
        foreach ($data as $k=>$value){      //数据匹配转换
            $data[$k]['app_source_id']=$app_source_id;
            $data[$k]['event_key']=$data[$k]['key'];
        }
        $eventTable=M('event_table');
        $delMap=array(
            'app_source_id'=>$app_source_id,
            'event'=>'click'
        );
        $eventTable->where($delMap)->select();
        $response=M('event_text_response');
        $response->where($delMap)->delete();    //删除回复表中旧的回复信息
        $eventTable->where($delMap)->delete();  //删除事件标中旧的回复设置
        $eventTable->addAll($data);     //将新的回复设置添加至事件表
        $response=M('event_text_response');
        $response->addAll($data);       //将新的回复信息写入事件回复表
    }
    //删除自定义菜单
    public function delete(){
        $MenuManager = new MenuManager();
        $response = $MenuManager->DeleteMenu();
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