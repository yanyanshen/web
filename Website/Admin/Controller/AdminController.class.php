<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
use Admin\Common\Controller\CommonController;
class AdminController extends CommonController{
    //管理员列表
    public function index(){
        if ($_GET['username']) {
            //搜索;
            $keywords = I('get.username');
            $where['username'] = array('like', "%$keywords%");
        } else {
            $where = '';
        }
        $admins = M('Admin');
        //总记录数;
        $count = $admins->where($where)->count();
        $page = new Page($count, 10);
        //分页展示;
        $show = $page->show();
        $adminList = $admins->where($where)->order('id')->limit($page->firstRow . ',' . $page->listRows)->select();
        //获得所属的管理员组;
            foreach($adminList as $k=>$v){
                $groupInfo=M('AuthGroupAccess')->alias('a')->join('xueches_auth_group g ON a.group_id=g.id')->field('g.title')->where("a.uid={$v['id']}")->select();
                $str='';
                foreach($groupInfo as $g){
                    $str.=$g['title'].',';
                }
                $adminList[$k]['group']=substr($str,0,-1);
            }
        $this->assign('firstRow', $page->firstRow);
        $this->assign('count',$count);
        $this->assign('adminList', $adminList);
        $this->assign('page', $show);
        $this->assign('get', $_GET);
        $this->assign('empty', "<h1>暂无数据</h1>");
        $this->display();
    }
    //添加管理员
    public function add_admin(){
        if(IS_AJAX){
            $admin = D('admin');
            $info = $admin->where(array('id'=>session('admin_id'),'permissions'=>1))->find();
            if($info){
                $data = $admin->create();
                $data['addtime'] = time();
                $data['edittime'] = time();
                $data['password'] = md5($data['password']);
                $res = $admin->add_admin($data);
                if($res){
                    $log['done'] = "管理员添加: => {$data['username']}";
                    D('AdminLog')->logout($log);
                    $this->success('添加成功',U('Admin/Admin/add_admin',array('pid'=>I('pid'))));
                }else{
                    $this->error('添加失败');
                }
            }
        }else{
            $this->assign('get',$_GET);
            $this->display();
        }
    }
/*
 * User：沈艳艳
 * Date：2017/08/28
 * 修改后台登陆者密码
 */
    public function set_password(){
        if(IS_AJAX){
            $_POST['id'] = session('admin_id');
            $_POST['password'] = md5($_POST['password']);
            $password = M('Admin')->where(array('id'=>session("admin_id")))->find();
            $res = M('Admin')->where(array('id'=>session("admin_id")))->save($_POST);
            if($res){
                $log['done'] = "管理员".session('admin_name')."密码:{$password['password']} => {$_POST['password']}";
                D('AdminLog')->logout($log);
                $this->success('修改成功',U('Admin/set_password',array('pid'=>I('pid'))));
            }else{
                $this->error('修改失败');
            }
        }else{
            $admin = M('admin')->where(array('id'=>session("admin_id")))->find();
            $this->assign('admin',$admin);
            $this->assign('get',$_GET);
            $this->assign('url',U('Admin/Admin/index',array('pid'=>I('pid'))));
            $this->display();
        }
    }
    //用AJAX方式更改管理员状态;
    public function operate(){
        if (IS_AJAX) {
            $admin = M('Admin');
            $where['permissions'] = 1;
            $where['username'] = session('admin_name');
            //判断管理权限;
            $pmsInfo = $admin->where($where)->field('permissions')->find();
            if ($pmsInfo) {
                //判断你要操作的管理员的权限;
                $data['id'] = I('post.id');
                $psInfo=$admin->where($data)->find();
                //只能操作非超级管理员的权限;
                if($psInfo['permissions']!=1){
                    $log['done'] = "管理员状态:{$psInfo['status']} => ";
                    //更改要操作的管理员状态;
                    $psInfo['status']=($psInfo['status']==0)?1:0;
                    $a=$admin->where($data)->field('status')->save($psInfo);
                    if($a){
                        $log['done'] = $log['done'].$psInfo['status'];
                        D('AdminLog')->logout($log);
                        $this->success('更新管理员状态成功',U('Admin/Admin/index',array('p'=>$_POST['p'],'pid'=>$_POST['pid'])));
                    }else{
                        $this->error('更新管理员状态失败',U('Admin/Admin/index',array('p'=>$_POST['p'],'pid'=>$_POST['pid'])));
                    }
                }else{
                    $this->error('你没有权限');
                }
            }else{
                $this->error('你没有权限');
            }
        }else{
            $this->display();
        }
    }
    //踢号操作;
    public function kick(){
        if (IS_AJAX) {
            $admin = M('Admin');
            $where['permissions'] = 1;
            $where['username'] = session('admin_name');
            //判断管理权限;
            $pmsInfo = $admin->where($where)->field('permissions')->find();
            if ($pmsInfo) {
                //判断你要操作的管理员的权限;
                $data['id'] = I('post.id');
                $psInfo=$admin->where($data)->find();
                //只能操作非超级管理员的权限;
                if($psInfo['permissions']!=1){
                    $log['done'] = "管理员登录状态:{$psInfo['online']} => ";
                    //更改要操作的管理员状态;
                    $psInfo['online']=0;
                    $a=$admin->where($data)->field('online')->save($psInfo);
                    if($a){
                        $log['done'] = $log['done'].$psInfo['online'];
                        D('AdminLog')->logout($log);
                        $this->success('更新管理员登录状态成功',U('Admin/Admin/index',array('pid'=>I('pid'),'p'=>I('p'))));
                    }else{
                        $this->error('更新管理员登录状态失败',U('Admin/Admin/index',array('pid'=>I('pid'),'p'=>I('p'))));
                    }
                }else{
                    $this->error('你没有权限');
                }
            }else{
                $this->error('你没有权限');
            }
        }else{
            $this->display();
        }
    }
    //验证账号数据库里是否有
    public function chkUsername(){
        $username = trim(I('post.username'));
        $admin = M('Admin');
        $info = $admin->where(array('username' => $username))->find();
        if ($info) {
            echo 'false';
        } else {
            echo 'true';
        }
    }
    //编辑操作;
    public function edit(){
        if (IS_AJAX) {
            $username=trim(I('post.username'));
            $password=trim(I('post.password'));
            $id=I('post.id');
            if($username){
                if($password){
                    $data['username']=$username;
                    $data['password']=md5($password);
                }else{
                    $data['username']=$username;
                }
                $data['edittime'] = time();
                $data['id'] = $id;
                $row=D('Admin')->editAdmin($data);
                if ($row) {
                    if (I('post.group_id')) {
                        $access = M('AuthGroupAccess');
                        $access->where(array('uid' => $id))->delete();
                        foreach (I('post.group_id') as $v) {
                            $info['uid'] = $id;
                            $info['group_id'] = $v;
                            $access->add($info);
                        }
                    }
                    $log['done'] = '编辑管理员信息';
                    D('AdminLog')->logout($log);
                    $this->success('用户编辑成功',  U('Admin/Admin/edit',array('id'=>I('id'),'p'=>I('p'),'pid'=>I('pid'))));
                } else {
                    $this->error('用户编辑失败');
                }
            }else{
                $this->error('用户名不能为空');
            }
        } else {
            $admin = D('Admin');
            $id = I('get.id');
            $adminInfo = $admin->getAdminById($id);
            $gid = M('AuthGroupAccess')->field('group_id')->where(array('uid' => $id))->select();
            foreach ($gid as $v) {
                $arr[] = $v['group_id'];
            }
            $adminInfo['gid'] = $arr;
            $groupList = D('AuthGroup')->getGroupList();
            $this->assign('groupList', $groupList);
            $this->assign('adminInfo', $adminInfo);
            $this->assign('get', $_GET);
            $this->assign('url', U('Admin/Admin/index',array('id'=>I('id'),'p'=>I('p'),'pid'=>I('pid'))));
            $this->display();
        }
    }
}