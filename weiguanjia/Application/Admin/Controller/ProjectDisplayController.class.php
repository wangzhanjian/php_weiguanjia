<?php
/**
 * Created by PhpStorm.
 * User: ji
 * Date: 2016/11/21
 * Time: 15:16
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Page;


class ProjectDisplayController extends Controller
{
    //新增
    Public function add(){
        $data['title'] = I('post.title');
        $data['content'] = I('post.content');
        $data['createtime'] = time();//组织数据
        $db = M('projectshow');
        $result = $db->data($data)->add();//添加
        if($result){
            //添加成功时跳转回列表页
            $this->success('添加成功', 'index');
        } else {
            //添加失败时返回上一页
            error_log($result,3,'./Public/log/log.txt');
            echo $result;
        }
    }
    //删除
    Public function delete(){
        $db = M('projectshow');
        $id = I('get.id');
        $result=$db->where('id=%d',array($id))->delete();//删除
        if($result){
            //删除成功时跳转回列表页
            $this->success('删除成功', 'index');
        } else {
            //删除失败时返回上一页
            error_log($result,3,'./Public/log/dynamiclog.txt');
            echo $result;
        }
    }
    public function modify(){
        $submit = I('post.submit');
        $db = M('projectshow');
        //判断是否在提交修改
        if ($submit != NULL){
            $id = I('post.id');
            $data['title'] = I('post.title');
            $data['content'] = I('post.content');
            $data['createtime'] = time();//组织数据
            $result = $db->where('id=%d',array($id))->save($data);
            if($result){
                //修改成功时跳转回列表页
                $this->success('修改成功', 'index');
            } else {
                //修改失败时返回上一页
                error_log($result,3,'./Public/log/dynamiclog.txt');
                echo $result;
            }
        }
        $id = I("get.id");
        $project = $db->where('id=%d',$id)->select();
        $this->assign('project',$project);
        $this->display();
    }
    //显示展示的项目列表
    Public function index(){
        $db = M('projectshow');//连接数据库
        $count = $db->count();
        $Page = new Page($count,10);
        $show = $Page->show();//创建分页
        $list = $db->order('Id')->field('Id,title,content,createtime')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
}