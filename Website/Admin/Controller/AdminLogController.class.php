<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
use Admin\Common\Controller\CommonController;
class AdminLogController extends CommonController{
/*
 * User: 沈艳艳
 * Date: 2017/8/18
 * Time: 15:52
 * 管理员日志展示
 */
    public function index(){
        $where = '';
        $admin = M('Admin')->where(array('id'=>session('admin_id')))->find();
        if($admin['permissions'] == 2){//超级管理员1可查看所有人的订单,普通管理员2只能查看自己的订单
            $_GET['id'] = session('admin_id');
        }

        if($admin['permissions'] != 1){//1可查看所有人的订单,其他只能查看自己的订单
            if($admin['authority'] == 0){
                $_GET['id'] = session('admin_id');
            }elseif($admin['authority'] == 1){
                $authGroupAccess = M('AuthGroupAccess')->field('group_id')->where(array('uid'=>session('admin_id')))->select();
                foreach($authGroupAccess as $v){
                    $str .= $v['group_id'].',';
                }
                $str = M('AuthGroupAccess')->DISTINCT(true)->field('uid')->where(array('group_id'=>array('in',$str)))->select();
                foreach($str as $k => $v){
                    $id .= $v['uid'].",";
                }
                $_GET['idArr'] = substr($id,0,-1);
            }
        }

        if(!empty($_GET)){
            foreach($_GET as $key=>$val) {
                if($key == 'username' && $val != ''){
                    $where .= " username like '%".trim($_GET['username'])."%' and";
                }elseif($key == 'id' && $val != ''){
                    $where .= " id = ".urldecode($val)." and";
                }elseif($key == 'idArr' && $val != ''){
                    $where .= " id in ($val) and";
                }
            }$where=rtrim($where,'and');

        }
        $admins = M('Admin');
        //总记录数;
        $count = $admins->where($where)->count();
        $page = new Page($count, 10);
        //分页展示;
        $show = $page->show();
        $adminLog = $admins->where($where)->order('lastlogin desc')->limit($page->firstRow . ',' . $page->listRows)->select();
        foreach($adminLog as $k => $v){
            $adminLog[$k]['permissions'] = M('Permissions')->where(array('id'=>$v['permissions']))->getField('permissions');
        }
        $this->assign('firstRow', $page->firstRow);
        $this->assign('count',$count);
        $this->assign('adminLog', $adminLog);
        $this->assign('page', $show);
        $this->assign('empty', "<h1>暂无数据</h1>");
        $this->assign('get',$_GET);
        $this->display();
    }
/*
 * User: 沈艳艳
 * Date: 2017/8/18
 * Time: 15:52
 * 管理员日志详情
 */
    public function admin_log_detail(){
        $_GET['start_time'] = strtotime(date('Y-m-d 00:00:00' , strtotime('-2 month')));
        if(!empty($_GET)){
            foreach($_GET as $key=>$val) {
                if($key == 'ntime' && $val != ''){
                    $val = strtotime(trim($val));
                    $where.="al.ntime >= $val and ";
                }elseif($key == 'ntime1' && $val != ''){
                    $val = strtotime(trim($val));
                    $where.="al.ntime  <= $val and ";
                }elseif($key == 'uid' && $val != ''){
                    $where.="al.uid = $val and ";
                } elseif($key == 'start_time' && $val != ''){
                    $where.="al.ntime >= $val and ";
                }
            }$where = rtrim($where,'and ');
        }
        switch($_GET['t']){
            case '0':
                $admins = M('AdminLog');
                $table = 'xueches_admin a,xueches_admin_log al';
                $where .= ' and al.uid=a.id';
                $field = 'a.username,al.done,al.ntime,al.lastip,al.uid,al.id';
                $display = 'admin_log_detail';
                break;
            case '1':
                $admins = M('OrderLog');
                $table = 'xueches_admin a,xueches_order_log al,xueches_order o';
                $where .= ' and a.id = al.uid and al.oid = o.id';
                $field = 'a.username,al.done,al.ntime,al.lastip,al.id,o.ordcode';
                $display = 'admin_order_log';
                break;
        }
        //总记录数;
        $count = $admins->table("$table")->where($where)->count();
        $page = new Page($count, 20);
        //分页展示;
        $show = $page->show();
        $admin_log_detail = $admins->table($table)->where($where)->field($field)
            ->order('al.ntime desc')
            ->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('firstRow', $page->firstRow);
        $this->assign('count',$count);
        $this->assign('adminLog', $admin_log_detail);
        $this->assign('page', $show);
        $_GET['url'] = U('Admin/AdminLog/index',array('p'=>I('pp'),'pid'=>I('pid')));
        $this->assign('empty', "<h1>暂无数据</h1>");
        $this->assign('get', $_GET);
        $this->display($display);
    }

/*---------------------------------2017-12-08shenyanyan------------------------*/
//管理员、订单日志导出
    public function push($t){
        $res = D('AdminLog')->push($_GET,$t);
        $this->success($res);
    }
}
