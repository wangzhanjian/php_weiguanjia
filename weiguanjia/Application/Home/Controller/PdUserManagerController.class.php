<?php
/**
 * Created by PhpStorm.
 * User: 田源
 * Date: 2016/11/29
 * Time: 16:13
 */

namespace Home\Controller;


use Curl\Curl;
use Wechat\UsersManager;

class PdUserManagerController extends BasisController
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

    //显示用户管理主界面
    public function index(){
        //获取用户信息
        $userinfo = $this->getUserInfo();
        foreach ($userinfo["user_info_list"] as $key=>$val){
            if ($userinfo["user_info_list"][$key]["sex"] == 1){
                $userinfo["user_info_list"][$key]["sex"] = "男";
            }elseif ($userinfo["user_info_list"][$key]["sex"] == 2){
                $userinfo["user_info_list"][$key]["sex"] = "女";
            }else{
                $userinfo["user_info_list"][$key]["sex"] = "保密";
            }
            $userinfo["user_info_list"][$key]["subscribe_time"] = date("Y-m-d",$userinfo["user_info_list"][$key]["subscribe_time"]);
        }
        //用户信息发送给模板，输出
        $this->assign("userinfo",$userinfo["user_info_list"]);
        //获取用户的标签分配到下拉列表
        $userlabel = $this->allLabel();
        $this->assignProjectCenterCommonInfo();
        $this->assign("userlabel",$userlabel);
        $this->display();
    }

    //将获取的用户列表重装,获取用户信息（o）
    public function getUserInfo(){
        //调用thinkPHP/Library/Wechat下的函数
        $usermanager = new UsersManager();
        $userlist_json = $usermanager->userList();
        //将json串转换为数组形式
        $userlist = json_decode($userlist_json,JSON_UNESCAPED_UNICODE);
        for ($i=0;$i<count($userlist["data"]["openid"]);$i++){ //循环数组
            //将获取的列表内容重新封装为另一种数组形式，供给用户信息输入
            $user_list["user_list"][$i]["openid"] = $userlist["data"]["openid"][$i];
        }
        $post_list = json_encode($user_list);
        //发送给用户内容函数
        $userinfo = $usermanager->userInfo($post_list);
        //输出内容
        $userinfo = json_decode($userinfo,true);
        foreach ($userinfo["user_info_list"] as $key=>$val){
            if ($userinfo["user_info_list"][$key]["country"] == null){
                $userinfo["user_info_list"][$key]["country"] = "保密";
            }
        }
        return $userinfo;
    }

    //点击标签 更换用户标签信息(o)
    public function changeLabel(){
        $usermanager = new UsersManager();
        $labelname_json = I('post.');
        $labelname = json_decode(htmlspecialchars_decode(json_encode($labelname_json,JSON_UNESCAPED_UNICODE)),true);
        //取消标签，然后打标签
        $changelabel = array(
            "openid_list" => array(
                $labelname["openid"]
            ),
            "tagid" => $labelname["label"]
        );
        $usermanager->cancelLabels(json_encode($changelabel));
        $newlabel_json = array(
            "openid_list" => array(
                $labelname["openid"]
            ),
            "tagid" => $labelname["label-now"]
        );
        $newuserlabel = $usermanager->moreUserLabel(json_encode($newlabel_json));
        return $newuserlabel;
    }

    //设置用户备注名
    public function alias(){
        $usermanager = new UsersManager();
        //获取用户名openID 以及新的备注名
        $data_json = I();
        $data = json_decode(htmlspecialchars_decode(json_encode($data_json,JSON_UNESCAPED_UNICODE)),true);
        //封装数组
        $remark_json = array(
            "openid" => $data["openid"],
            "remark" => $data["remark"]
        );
        $usermanager->updateNode(json_encode($remark_json,JSON_UNESCAPED_UNICODE));
    }

    //获取用户的标签列表(o)
    public function labellist(){
        $usermanager = new UsersManager();
        $list_json = "
        {
            'openid' : 'oNwgwxBHzlyCRHEtkj4TzuthNr5E'
        }
        ";
        $usermanager->getUserLabel($list_json);
    }

    //将用户加入黑名单
    public function shieldUsers(){
        $usermanager = new UsersManager();
        //获取加入黑名单的用户
        $openid = I();
        //数组
        $user = array(
            "opened_list" => array(
                $openid['openid']
            )
        );
        $usermanager->shieldUsers(json_encode($user));
        echo "success";
    }

    //取消拉黑用户
    public function undoUsers(){
        $usermanager = new UsersManager();
        //获取取消拉黑的用户
        $openid = I();
        //数组
        $user = array(
            "opened_list" => array(
                $openid['openid']
            )
        );
        $usermanager->undoUsers(json_encode($user));
        echo "success";
    }

    //显示新建标签页
    public function newLabelPage(){
        $labels = $this->allLabel();
        $this->assign("labels",$labels);
        $this->assignProjectCenterCommonInfo();
        $this->display();
    }

    //获取全部标签(o)
    public function allLabel(){
        $usermanager = new UsersManager();
        $userlabel_json = $usermanager->allLabel();
        $userlabel = json_decode($userlabel_json,JSON_UNESCAPED_UNICODE);
        for ($i=0;$i<count($userlabel["tags"]);$i++){
            $labelname[$i]["name"] =  $userlabel["tags"][$i]["name"];
            $labelname[$i]["id"] =  $userlabel["tags"][$i]["id"];
        }
        return $labelname;
    }

    //创建标签(o)
    public function createLabel(){
        $usermanager = new UsersManager();
        //获取新建的标签名
        $labelname = I('post.');
        //构建数组json串给createLabel函数
        $label_json = "{
                \"tag\" : {
                \"name\" : \"".$labelname['labelname']."\"//标签名
                      }
                   }";
        $usermanager->createLabel($label_json);
        $this->redirect("/Home/PdUserManager/newLabelPage",0);
    }

    //点击移除分组，删除标签（标签内成员不删除 移动到未分组标签）
    public function deleteLabel(){
        $usermanager = new UsersManager();
        //获取要删除的分组
        $labelid = I();
        //封装数组
        $deletelabel_json = array(
            "tag" => array(
                "id" => $labelid["openid"]
            )
        );
        $deletelabel = $usermanager->deleteLabel(json_encode($deletelabel_json));
        if (json_decode($deletelabel,true)["errcode"]==0){
            echo "ok";
        }
    }

    //取消用户标签
    public function cancelLabels(){
        $usermanager = new UsersManager();
        //获取
        $labelname_json = I('post.');
        $labelname = json_decode(htmlspecialchars_decode(json_encode($labelname_json,JSON_UNESCAPED_UNICODE)),true);
        $changelabel = array(
            "openid_list" => array(
                $labelname["openid"]
            ),
            "tagid" => $labelname["tag_id"]
        );
        $canceluserlabel = $usermanager->cancelLabels(json_encode($changelabel));
        if (json_decode($canceluserlabel,true)["errcode"]==0){
            echo "ok";
        }
    }

    //进入标签 显示标签对应页面
    public function labelPage(){
        $usermanager = new UsersManager();
        $group = I();
        $data = '{"tagid":'.$group["group_id"].'}';
        $users = $this->allUsers($data);
        for ($i=0;$i<count($users["data"]["openid"]);$i++){ //循环数组
            //将获取的列表内容重新封装为另一种数组形式，供给用户信息输入
            $user_list["user_list"][$i]["openid"] = $users["data"]["openid"][$i];
        }
        $post_list = json_encode($user_list);
        //发送给用户内容函数
        $userinfo = $usermanager->userInfo($post_list);
        //输出内容
        $userinfo = json_decode($userinfo,true);
        $this->assign("userinfo",$userinfo);
        $this->assign("labelname",$group);//labelPage
        $this->assignProjectCenterCommonInfo();
        $this->display();
    }

    //获取标签内用户列表
    protected function allUsers($group){
        $usermanager = new UsersManager();
        $labeluser_json = $usermanager->getLabelUsers($group);
        //将json串转换为数组形式
        $userlist = json_decode($labeluser_json,JSON_UNESCAPED_UNICODE);
        return $userlist;
    }

    //获取黑名单列表(暂无)
    public function blackUserList(){
        $usermanager = new UsersManager();
        $deletelabel_json = array(
            "begin_openid" => "OPENID1"
        );
        $usermanager->getBlackList(json_encode($deletelabel_json));
    }

}