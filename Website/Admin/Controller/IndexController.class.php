<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Controller\CommonController;
class IndexController extends CommonController {
    public function index(){
        $this->display();
    }
    //头部
    public function head(){
        $this->display();
    }
    //左边菜单
    public function left(){
            //获取左侧栏菜单
        $nav=D('AdminNav');
        $navList=$nav->getNavTree();
        $this->assign('navList',$navList);
        $this->display();
    }
    //右边
    public function right(){
        $admin = M('admin')->where("id = ".session('admin_id'))->find();
        $this->assign('admin',$admin);
        $this->display();
    }

}
