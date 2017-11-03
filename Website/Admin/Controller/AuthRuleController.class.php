<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Controller\CommonController;
class AuthRuleController extends CommonController{
//权限菜单列表;
    public function index(){
        //判断是否有管理组添加的权限
        $pid = I('pid');
        $add_group = D('AuthRule')->getRule($pid,'权限添加');

        $_GET['add_rule'] = $add_group['name'];

        $this->assign('get',$_GET);
        $rule=D('AuthRule');
        $ruleList=$rule->getRuleList();
        $this->assign('ruleList',$ruleList);
        $this->display();
    }
//添加权限
    public function add_rule(){
        if(IS_AJAX){
            $url = U('Admin/AuthRule/index',array('pid'=>I('ppid')));
            $rule=D('AuthRule');
            $data=$rule->create();
            if($data){
                $nid=$rule->add_rule($data);
                if($nid){
                    $log['done'] = '添加权限 ID_'.$nid;
                    D('AdminLog')->logout($log);
                    $this->success('权限添加成功',$url);
                }else{
                    $this->error('权限添加失败');
                }
            }else{
                $this->error($rule->getError());
            };
        }else{
            $this->assign('get',$_GET);
            $this->assign('url',U('Admin/AuthRule/index',array('pid'=>I('ppid'))));
            $this->display();
        }
    }
//删除权限
    public function del(){
        if(IS_AJAX) {
            $id = I('post.id');
            $info = M('AuthRule')->where(array('id' => $id))->find();
            if ($info) {
                $where['path'] = array('like', "{$id}%");
                $pathInfo = M('AuthRule')->where($where)->select();
                if ($pathInfo) {
                    $res = M('AuthRule')->where($where)->delete();
                } else {
                    $res = M('AuthRule')->where(array('id'=>$id))->delete();
                }
                if($res){
                    $log['done'] = '删除权限 ID_'.$res;
                    D('AdminLog')->logout($log);
                    $this->success('删除成功',U('Admin/AuthRule/index',array('pid'=>I('pid'))));
                }else{
                    $this->error('删除失败');
                }
            } else {
                $this->error('没有找到数据');
            }
        }
    }
//编辑权限;
    public function edit(){
        if(IS_AJAX){
            $id=I('post.id');
            if (I('post.thirdRule')) {
                $pid = I('post.thirdRule');
            } elseif (I('post.secondRule')) {
                $pid = I('post.secondRule');
            } else {
                $pid = I('post.firstRule');
            }
//如果选择的分类的pid=0则让添加的分类新path=它自己的id;
            if($pid==0){
                $newpath=$id;
            }else{
                $pathInfo=M('AuthRule')->field('path')->where(array('id'=>$pid))->find();
                $newpath=$pathInfo['path'].','.$id;
            }
            $data['name']=trim(I('post.name'));
            $data['title']=trim(I('post.title'));
            $data['pid']=$pid;
            $data['path']=$newpath;
            $data['id']=$id;
            $info=D('AuthRule')->edit($data);
            if($info){
                $log['done'] = '编辑权限 ID_'.$id;
                D('AdminLog')->logout($log);
                $this->success('编辑成功',U('Admin/AUthRule/index',array('pid'=>I('pid'))));
            }else{
                $this->error('编辑失败');
            }
        }else{
            $this->assign('get',$_GET);
            $this->assign('url',U('Admin/AuthRule/index',array('pid'=>I('pid'))));
            $id=I('get.id');
            $rule=M('AuthRule');
            $data=$rule->where(array('id'=>$id))->find();
            if($data){
                $this->assign('id',$id);
                $this->assign('title',$data['title']);
                $this->assign('name',$data['name']);
                $this->display();
            }else {
                $this->display('AuthRule/index');
            }
        }
    }

//显示三级联动分类;
    public function getRuleByPid(){
        $pid=I('post.pid',0);                         //判断pid,如果没有则默认为pid=0
        $ruleList=D('AuthRule')->getRuleByPid($pid);  //通过实例化AuthRule类来调用getRuleByPid()方法得到数据;
        if($ruleList){
            $this->success($ruleList);
        }else{
            $this->error("查询失败");
        }
    }
}