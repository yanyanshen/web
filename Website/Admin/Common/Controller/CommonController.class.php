<?php
namespace Admin\Common\Controller;
use Think\Controller;
class CommonController extends Controller{
    public function __construct(){
        parent::__construct();
        //查看ip是否 被禁止
        $IP = get_client_ip();
        $iplist = M('client_ips')->where(array('status'=>1))->field('ip')->select();
        for($i=0;$i<count($iplist);$i++){
            $list[$i] = $iplist[$i]['ip'];
        }
        if(!session('admin_id')){
            $this->redirect('Admin/Login/login');
        }else{
            $adminInfo = M('Admin')->field('permissions,online,status')->where(array('id'=>session('admin_id')))->find();
            if($adminInfo['permissions'] == 2 ){//超级管理员
                if(!in_array($IP,$list)){
                    exit('You don\'t have permission to access!');
                }else{
                    if($adminInfo['online'] == 0 || $adminInfo['status'] == 0){
                        session('admin_id',null);
                        exit('You don\'t have permission to access!');
                    }
                }
            }
        }
    }
    function _empty($name){
        //把所有城市的操作解析到city方法
        echo "页面有误";
    }
}

