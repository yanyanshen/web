<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Controller\CommonController;
class AdminNavController extends CommonController{
//菜单列表
    public function index(){
        //判断是否有菜单添加的权限
        $pid = I('pid');
        $add_group = D('AuthRule')->getRule($pid,'菜单添加');
        $_GET['add_nav'] = $add_group['name'];
        $this->assign('get',$_GET);
        $nav=D('AdminNav');
        $navList=$nav->getNavList();
        $this->assign('navList',$navList);
        $this->display();
    }
//菜单、子菜单添加
    public function add_nav(){
        $_GET['url'] = U('Admin/AdminNav/index',array('pid'=>$_GET['ppid']));
        $this->assign('get',$_GET);
        if(IS_AJAX){
            $nav=D('AdminNav');
            if($_POST){
                $nid=$nav->add_nav($_POST);
                if($nid){
                    $log['done'] = '添加菜单';
                    D('AdminLog')->logout($log);
                    $this->success('菜单添加成功',U('Admin/AdminNav/index',array('pid'=>I('ppid'))));
                }else{
                    $this->error('菜单添加失败',U('Admin/AdminNav/index',array('pid'=>I('ppid'))));
                }
            }else{
                $this->error($nav->getError());
            };
        }else{
            $this->display();
        }
    }
//编辑菜单
    public function edit(){
        if(IS_AJAX){
            $id=I('post.id');
            $nav=M('AdminNav');
            $data['navname']=trim(I('post.navname'));
            $data['navurl']=trim(I('post.navurl'));
            $info=$nav->where(array('id'=>$id))->find();
            if($info){
                if($nav->where(array('id'=>$id))->save($data)){
                    $log['done'] = '编辑菜单';
                    D('AdminLog')->logout($log);
                    $this->success('编辑成功',U('index',array('pid'=>I('pid'))));
                }else{
                    $this->error('编辑失败');
                }
            }else{
                $this->error('没有查到数据');
            }
        }else{
            $id=I('get.id');
            $nav=M('AdminNav');
            $navInfo=$nav->where(array('id'=>$id))->find();
            $this->assign('get',$_GET);
            $this->assign('navname',$navInfo['navname']);
            $this->assign('navurl',$navInfo['navurl']);
            $this->assign('url',U('Admin/AdminNav/index',array('pid'=>I('pid'))));
            $this->display();
        }
    }
//删除菜单
    public function del(){
        $id=I('post.id');
        $nav=M('AdminNav');
        $info=$nav->where(array('id'=>$id))->find();
        if($info){
            $where['path']=array('like',"$id%");
            $pathInfo=$nav->where($where)->select();
            if($pathInfo){
                $res = $nav->where($where)->delete();
                if($res){
                    $this->success('删除成功',U('Admin/AdminNav/index',array('pid'=>I('pid'))));
                }else{
                    $this->error('删除失败');
                }
            }else{
                $res = $nav->where(array('id'=>$id))->delete();
            }
            if($res){
                $log['done'] = '删除了菜单';
                D('AdminLog')->logout($log);
                $this->success('删除成功',U('Admin/AdminNav/index',array('pid'=>I('pid'))));
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('没有查到数据');
        }
    }

    //设置菜单优先级
    public function setPriority(){
        if(IS_AJAX){
            $nav=D('AdminNav');
            $data=$nav->create();
            if($data){
                $row=$nav->setPriority($data);
                if($row){
                    $log['done'] = '更新了左边菜单优先级';
                    D('AdminLog')->logout($log);
                    $this->success('优先级更新成功');
                }
            }else{
                $this->error($nav->getError());
            }
        }
    }
}