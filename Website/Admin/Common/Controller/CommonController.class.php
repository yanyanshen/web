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
//        print_r($IP);
//        if(!in_array($IP,$list)){
//            exit('You don\'t have permission to access!');
//        }
        if(!session('admin_id')){
            $this->redirect('Admin/Login/login');
        }
    }
}

