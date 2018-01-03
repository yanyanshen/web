<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Controller\CommonController;
class ClientIpsController extends CommonController{
/*----------------------------------2017-12-04shenyanyan----------------------------*/
//clientIps列表展示
    public function index(){
        $iplist = D('ClientIps')->index($_GET);
        $this->assign('get',$_GET);
        $this->assign('iplist',$iplist);
        $this->display();
    }
//clientIps编辑
    public function edit_ips(){
        if(IS_AJAX){
            $_POST['cityname'] = getCity();
            $_POST['edit_time'] = date('Y-m-d H:i:s',time());//修改时间
            $_POST['last_name'] = session('admin_name');//最后更新人
            //原来的ip信息
            $info = M('client_ips')->field('ip,cityname')->where(array('id'=>I('id')))->find();
            $log['done'] = "ClientIps信息:{$info['ip']}({$info['cityname']}) => {$_POST['ip']}({$_POST['cityname']})";
            $res = M('client_ips')->save($_POST);
            if($res){
                D('AdminLog')->logout($log);
                $this->success('修改成功',U('Admin/ClientIps/index',array('pid'=>I('pid'),'p'=>I('p'))));
            }else{
                $this->error('修改失败');
            }
        }else{
            $_GET['url'] = U('Admin/ClientIps/index',array('pid'=>I('pid'),'p'=>I('p')));
            $this->assign('get',$_GET);
            $iplist = M('client_ips')->where(array('id'=>I('id')))->find();
            $this->assign('iplist',$iplist);
            $this->display();
        }
    }
//删除
    public function batch_operate_del(){
        $id_arr = explode(',',I('str'));
        foreach($id_arr as $v){
            $info = M('client_ips')->field('ip,cityname')->where(array('id'=>$v))->find();
            $log['done'] = "ClientIps删除信息: => {$info['ip']}({$info['cityname']})";
            D('AdminLog')->logout($log);
            M('client_ips')->delete($v);
        }
        $this->redirect('Admin/ClientIps/index',array('pid'=>I('pid'),'p'=>I('p')));
    }
//clientIps添加
    public function add_ips(){
        if(IS_AJAX){
            $_POST['cityname'] = getCity();
            if(M('client_ips')->where(array('ip'=>I('ip'),'cityname'=>getCity()))->find()){
                $this->error('该IP已经被添加');
            }else{
                $_POST['create_name'] = session('admin_name');//创建人
                $_POST['last_name'] = session('admin_name');//最后更新人
                $_POST['ntime'] = date('Y-m-d H:i:s',time());//创建时间
                $_POST['edit_time'] = date('Y-m-d H:i:s',time());//修改时间

                $last_id = M('ClientIps')->add($_POST);
                if($last_id){
                    //添加日志
                    $log['done'] = "ClientIps添加信息: => {$_POST['ip']}({$_POST['cityname']})";
                    D('AdminLog')->logout($log);
                    $this->success('添加成功',U('Admin/ClientIps/index',array('pid'=>I('pid'),'p'=>I('p'))));
                }else{
                    $this->error('添加失败');
                }
            }
        }else{
            $_GET['url'] = U('Admin/ClientIps/index',array('pid'=>I('pid'),'p'=>I('p')));
            $this->assign('get',$_GET);
            $this->display();
        }
    }
}
