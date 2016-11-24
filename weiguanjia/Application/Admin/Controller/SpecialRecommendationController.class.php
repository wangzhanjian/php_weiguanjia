<?php
/**
 * Created by PhpStorm.
 * User: ji
 * Date: 2016/11/21
 * Time: 15:14
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Page;


class SpecialRecommendationController extends Controller
{
    protected $db;//定义数据库对象
    Public function __construct(){
        parent::__construct();
        $this->db = M('features');//连接数据库
    }
    //新增
    Public function add(){
        $data['title'] = I('post.title');
        $data['content'] = I('post.content');
        $result = $this->db->data($data)->add();
        if($result){
            //添加成功时跳转回列表页
            $this->redirect('index');
        } else {
            //添加失败时返回上一页
            error_log($result,3,'./Public/log/log.txt');
            echo $result;
        }
    }
    //删除
    Public function delete(){
        $id = I('get.id');
        $result=$this->db->where('id=%d',array($id))->delete();//删除
        if($result){
            //删除成功时跳转回列表页
            $this->success('删除成功', 'index');
        } else {
            //删除失败时返回上一页
            error_log($result,3,'./Public/log/speciallog.txt');
            echo $result;
        }
    }
    //修改
    public function modify(){
        $submit = I('post.submit');
        if ($submit != NULL){
            $id = I('post.id');
            $data['title'] = I('post.title');
            $data['content'] = I('post.content');
            $data['createtime'] = time();
            $result = $this->db->where('id=%d',array($id))->save($data);
            if($result){
                //修改成功时跳转回列表页
                $this->success('修改成功', 'index');
            } else {
                //修改失败时返回上一页
                error_log($result,3,'./Public/log/speciallog.txt');
                echo $result;
            }
        }
        $id = I("get.id");
        $article = $this->db->where('id=%d',$id)->select();
        $this->assign('article',$article);
        $this->display();
    }
    //显示推荐列表操作页
    Public function index(){
        $count = $this->db->count();
        $Page = new Page($count,10);
        $show = $Page->show();//创建分页
        $list = $this->db->order('Id')->field('Id,title,content,createtime')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
}