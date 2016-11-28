<?php
/**
 * Created by PhpStorm.
 * User: ji
 * Date: 2016/11/21
 * Time: 15:11
 */
namespace Admin\Controller;


use Think\Controller;
use Think\Page;

class ShufflingImgController extends Controller
{
    //新增
    Public function add(){
        header('Content-type:text/html;charset=utf8');
        $upload = new \Think\Upload();// 实例化上传类
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Public/Admin/ShufflingImg/'; // 设置附件上传根目录
        $upload->autoSub = false;
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            error_log("add".$upload->getError(),3,'./Public/log/shufflinglog.txt');
            $this->error('上传失败');
        }else{// 上传成功
            dump($info);
            $data['src'] = "/Admin/ShufflingImg/".$info['img_img']["savename"];
            $data['imgname'] = I("post.img_name");
            dump($data);
            $db = M("shuffling_img");
            $db->data($data)->add();
            $this->success('上传成功',"index");
        }
    }
    //删除
    Public function delete(){
        $id = I("get.id");//获取ID
        $db = M("shuffling_img");//连接数据库
        $result=$db->where('id=%d',array($id))->delete();//删除
        if($result){
            //删除成功时跳转回列表页
            $this->success('删除成功', 'index');
        } else {
            //删除失败时返回上一页
            error_log($result,3,'./Public/log/shufflinglog.txt');
        }
    }
    //显示图片列表操作页面
    Public function index(){
        $db = M('shuffling_img');//连接数据库
        $count = $db->count();
        $Page = new Page($count,6);
        $show = $Page->show();//创建分页
        $list = $db->order('Id')->field('Id,imgname,src')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
}