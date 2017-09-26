<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Controller\CommonController;
class AuthGroupController extends CommonController{
//管理组列表
    public function index(){
        $group=D('AuthGroup');
        $groupList=$group->getGroupList();
        foreach($groupList as $k=>$v){
            $adminInfo=M('AuthGroupAccess')->alias('g')->join('xueches_admin a ON g.uid=a.id')->field('a.username')->where("g.group_id={$v['id']}")->select();
            $str='';
            foreach($adminInfo as $a){
                $str.=$a['username'].',';
            }
            $groupList[$k]['member']=substr($str,0,-1);
        }
        $this->assign('groupList',$groupList);
        $this->display();
    }
//添加管理组;
    public function add_group(){
        if(IS_AJAX){
            $group=D('AuthGroup');
            $data=$group->create();
            if($data){
                if($data['id']){
                    $gid=$group->save($data);
                }else{
                    $gid=$group->add_group($data);
                }
                if($gid){
                    $this->success('编辑成功',U('index'));
                }else{
                    $this->error('编辑失败');
                }
            }else{
                $this->error($group->getError());
            };
        }else{
            if(I('id')){
                $id = I('id');
                $this->assign('btn','管理组编辑');
                $title = M('AuthGroup')->where("id = $id")->getField('title');
                $this->assign('title',$title);
                $this->assign('id',$id);
            }
            $this->display();
        }
    }
//给管理组分配权限;
    public function allocateRule(){
        $group=D('AuthGroup');
        if(IS_AJAX){
            $data['id']=I('post.id');
            $data['rules']=implode(',',I('post.rules'));
            $row=$group->editRule($data);
            if($row){
                $this->success('分配成功',U('index'));
            }else{
                $this->error('分配失败');
            }
        }else{
            //获取所有权限规则
            $rule=D('AuthRule');
            $ruleList=$rule->getRuleTree();
            //获取组信息
            $id=I('get.gid');
            $groupInfo=$group->find($id);
            $groupInfo['rules']=explode(',',$groupInfo['rules']);
            $this->assign('ruleList',$ruleList);
            $this->assign('groupInfo',$groupInfo);
            $this->display();
        }

    }
//删除管理组;
    public function del(){
        if(IS_AJAX) {
            $id = I('post.id');
            $group = M('AuthGroup');
            $access=M('AuthGroupAccess');
            $groupInfo=$group->where(array('id' => $id))->find();
            $accessInfo=$access->where(array('group_id'=>$id))->select();
            //判断管理组以及组员是否存在,然后分别删除;
            if($groupInfo) {
                if($accessInfo) {
                    $group->startTrans();
                    if (!$group->where(array('id' => $id))->delete()) {
                        $group->rollback();
                    }
                    if(!$access->delete(array('group_id'=>$id))->delete()){
                        $group->rollback();
                    }
                    $res = $group->commit();
                }else{
                    $res = $group->delete($accessInfo);
                }
                if($res){
                    $this->success('删除成功');
                }else{
                    $this->error('删除失败');
                }
            }else{
                $this->error('没有查到数据');
            }
        }
    }
//添加组员
    public function add_member(){
        if(IS_AJAX){
            if(trim(I('username'))){
                $userInfo = M('admin')->where(array('username'=>trim(I('username'))))->find();
                $gid = I('gid');
                if($userInfo){
                    $data['uid'] = $userInfo['id'];
                    $data['group_id'] = $gid;
                    $accessInfo = M('AuthGroupAccess')->where($data)->find();
                    if($accessInfo){
                        $this->error('该组员已存在');
                    }else{
                        if(M('AuthGroupAccess')->add($data)){
                            $this->success('添加成功');
                        }else{
                            $this->error('添加失败');
                        }
                    }
                }else{
                    $this->error('这条数据不存在');
                }
                //勾选的管理员名字
            }elseif(I('post.uid')){
                $access = M('AuthGroupAccess');
                $access->where(array('group_id'=>I('post.gid')))->delete();
                foreach(I('post.uid') as $v1){
                    $data['uid'] = $v1;
                    $data['group_id'] = (trim(I('post.gid')));
                    $res = $access->add($data);
                }
                if($res){
                    $this->success('添加成功');
                }else{
                    $this->error('添加失败');
                }
            }else{
                $this->error('管理员名称不能为空');
            }
        }else{
            $gid = I('gid');
            $admins = M('admin')->select();
            $accessInfo = M('AuthGroupAccess')->table('xueches_admin a,xueches_auth_group_access g')
                ->where(array('g.group_id'=>$gid,'a.id = g.uid'))->select();
            $uid = M('AuthGroupAccess')->field('uid')->where(array('group_id'=>$gid))->select();
            foreach($uid as $v){
                $arr[] = $v['uid'];
            }
            $accessInfo['uid'] = $arr;
            $this->assign('gid',$gid);
            $this->assign('admins',$admins);
            $this->assign('accessInfo',$accessInfo);
            $this->display();
        }
    }
}