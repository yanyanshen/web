<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Controller\CommonController;
class UserLogController extends CommonController{
/*
 * User：沈艳艳
 * Date：2018/08/28
 * 用户日志展示
 */
    public function index(){
        //管理员列表
        if (IS_GET) {
            //搜索;
            $keywords = I('get.username');
            $where['truename'] = array('like', "%$keywords%");
        } else {
            $where = '';
        }
        $count = M('UserLog')->alias('ul')
            ->join('xueches_user u ON u.id = ul.uid')
            ->where($where)->count();
        $page = new \Think\Page($count,20);
        $show = $page->show();
        $UserLog = M('UserLog')->alias('ul')->join('xueches_user u ON u.id = ul.uid')
            ->field('ul.*,u.truename,u.account,u.phone,u.lastip,u.lasttime')
            ->limit($page->firstRow.','.$page->listRows)
            ->where($where)->select();
        $this->assign('UserLog',$UserLog);
        $this->assign('firstRow',$page->firstRow);
        $this->assign('page',$show);
        $this->assign('count',$count);
        $this->assign('get',$_GET);
        $this->display();
    }
}
