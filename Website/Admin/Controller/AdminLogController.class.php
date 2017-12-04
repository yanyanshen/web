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
            $_GET['uid'] = session('admin_id');
        }

        if(!empty($_GET)){
            foreach($_GET as $key=>$val) {
                if($key == 'username' && $val != ''){
                    $where .= " username like '%".trim($_GET['username'])."%' and";
                }elseif($key == 'uid' && $val != ''){
                    $where .= " uid = ".urldecode($val)." and";
                }
            }$where=rtrim($where,'and');

        }
        $admins = M('Admin');
        //总记录数;
        $count = $admins->where($where)->count();
        $page = new Page($count, 20);
        //分页展示;
        $show = $page->show();
        $adminLog = $admins->where($where)->order('lastlogin desc')->limit($page->firstRow . ',' . $page->listRows)->select();
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
        $where = "al.uid=".I('uid');
        if(!empty($_GET)){
            foreach($_GET as $key=>$val) {
                if($key == 'ntime' && $val != ''){
                    $val = strtotime(trim($val));
                    $where.=" and al.ntime  > $val";
                }elseif($key == 'ntime1' && $val != ''){
                    $val = strtotime(trim($val));
                    $where.=" and al.ntime  < $val";
                }
            }
        }
        switch($_GET['t']){
            case '0':
                $admins = M('AdminLog');
                $table = 'xueches_admin a,xueches_admin_log al';
                $where .= ' and al.uid=a.id';
                $field = 'a.username,al.done,al.ntime,al.lastip';
                $display = 'admin_log_detail';
                break;
            case '1':
                $admins = M('OrderLog');
                $table = 'xueches_admin a,xueches_order_log al,xueches_order o';
                $where .= ' and al.uid=a.id and al.oid=o.id';
                $field = 'a.username,al.done,al.ntime,al.lastip,o.ordcode';
                $display = 'admin_order_log';
                break;
        }

        //总记录数;
        $count = $admins->table($table)->where($where)->count();
        $page = new Page($count, 20);
        //分页展示;
        $show = $page->show();
        $admin_log_detail = $admins->table($table)->where($where)->field($field)->order('al.ntime desc')
            ->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('firstRow', $page->firstRow);
        $this->assign('count',$count);
        $this->assign('adminLog', $admin_log_detail);
        $this->assign('page', $show);
        $_GET['url'] = U('Admin/AdminLog/index',array('p'=>I('p'),'pid'=>I('pid')));
        $this->assign('get',$_GET);
        $this->assign('empty', "<h1>暂无数据</h1>");
        $this->display($display);
    }
}
