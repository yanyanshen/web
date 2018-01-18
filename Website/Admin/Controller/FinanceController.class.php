<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Controller\CommonController;
class FinanceController extends CommonController{
/*---------------------------------------2017-11-10shenyanyan-----------------------------------*/
//待结算订单页面
    public function wait_account(){
        $_POST['lastupdate'] = session('admin_name');
        if(I('t') == 1){//退费
            $_POST['order_status'] = 6;
            $_POST['status'] = 6;
            $_POST['return_fee'] = date('Y-m-d H:i:s',time());
            $res = M('Order')->save($_POST);
            $log = "退费{$_POST['return_money']}元";
        }elseif(I('t') == 3){//取消
            $log = '订单取消';
            $_POST['order_status'] = 5;
            $_POST['status'] = 5;
            $_POST['cancel_time'] = date('Y-m-d H:i:s',time());
            $res = M('Order')->save($_POST);
        }
        if($res){
            D('AdminLog')->addOrderLog($log,I('id'));
            $this->redirect("wait_account",array('pid'=>I('pid'),'p'=>I('p')),0,"<script>alert('退款成功')</script>");
        }

        $_GET['order_status'] = 3;
        $arr = D('order')->order_list($_GET);
        $this->assign('arr', $arr);
        $reason = M('OrderCancelReason')->select();
        $this->assign('reason',$reason);
        $this->assign('get',$_GET);
        $this->display();
    }
//已结算订单列表
    public function end_account(){
        if(I('id')){
            $data['lastupdate'] = session('admin_name');
            $data['end_time'] = date('Y-m-d H:i:s',time());
            $data['order_status'] = 4;//结算
            $data['status'] = 3;//结算
            $data['id'] = I('id');
            $res = M('Order')->save($data);
            if($res){
                $log = '订单结算';
                D('AdminLog')->addOrderLog($log,I('id'));
                $this->redirect('wait_account',array('pid'=>I('pid'),'p'=>I('p')),0,'');
            }else{
                echo 'false';
            }
        }else{
            $_GET['order_status'] = 4;
            $arr = D('Order')->order_list($_GET);
            $this->assign('arr', $arr);
            $this->assign('get',$_GET);
            $this->display();
        }
    }
//已退费订单列表
    public function return_account(){
        if(I('id')){
            $_POST['order_status'] = 6;
            $_POST['status'] = 6;
            $_POST['lastupdate'] = session('admin_name');
            $_POST['return_fee'] = date('Y-m-d H:i:s',time());
            $log = "退费{$_POST['return_money']}元";
            $res = M('Order')->save($_POST);
            if($res){
                D('AdminLog')->addOrderLog($log,I('id'));
                $this->redirect("end_account",array('pid'=>I('pid'),'p'=>I('p')),0,"<script>alert('退款成功')</script>");
            }else{
                $this->redirect("end_account",array('pid'=>I('pid'),'p'=>I('p')),0.1,"<script>alert('退款失败')</script>");
            }
        }else{
            $_GET['order_status'] = 6;
            $arr = D('Order')->order_list($_GET);
            $this->assign('arr', $arr);
            $this->assign('get', $_GET);
            $this->display();
        }
    }

//订单取消列表
    public function cancel_order(){
        $_GET['order_status'] = 5;
        $arr = D('order')->order_list($_GET);
        $this->assign('arr', $arr);
        $order_cancel = M('OrderCancelReason')->select();
        $this->assign('order_cancel',$order_cancel);
        $this->assign('get',$_GET);
        $this->display();
    }
/*----------------------------------2017-11-23shenyanyan---------------------------*/
//批量退款
    public function batch_operate(){
        if(IS_AJAX){
            foreach($_POST['id'] as $k => $v){
                $str .= $v.',';
            }
            $str = substr($str,0,-1);
            $data['str'] = $str;
            $this->success($data);
        }else{
            $_POST['lastupdate'] = session('admin_name');
            switch(I('type')){
                case '取消':
                    $new_cancel_reason = M('order_cancel_reason')->where(array('id'=>$_POST['cancel_reason']))->getField('reason');
                    $log = "订单取消原因: => {$new_cancel_reason}";
                    $_POST['status'] = 5;
                    $_POST['order_status'] = 5;
                    $_POST['cancel_time'] = date('Y-m-d H:i:s',time());
                    break;
                case '退费':
                    $log = '退费'.I('return_money').'元';
                    $_POST['status'] = 6;
                    $_POST['order_status'] = 6;
                    $_POST['return_fee'] = date('Y-m-d H:i:s',time());
                    break;
                case '结算':
                    $log = '订单结算';
                    $_POST['status'] = 3;
                    $_POST['order_status'] = 4;
                    $_POST['end_time'] = date('Y-m-d H:i:s',time());
                    break;
            }
            $id_arr = explode(',',I('str'));
            foreach($id_arr as $v){
                $_POST['id'] = $v;
                M('Order')->save($_POST);
                D('AdminLog')->addOrderLog($log,$v);
            }
            $this->redirect('Admin/Finance/wait_account',array('pid'=>I('pid'),'p'=>I('p')));
        }
    }
//批量修改取消订单原因
    function cancel_reason(){
        $_POST['lastupdate'] = session('admin_name');
        $_POST['cancel_time'] = date('Y-m-d H:i:s',time());

        $id_arr = explode(',',I('str'));
//        $log = '订单取消原因: => '.$new_cancel_reason;
        foreach($id_arr as $v){
            //原来的取消原因id
            $cancel_reason_id = M('Order')->where(array('id'=>$v))->getField('cancel_reason');
            //现在的取消原因
            $new_cancel_reason = M('order_cancel_reason')->where(array('id'=>$_POST['cancel_reason']))->getField('reason');
            if($cancel_reason_id == 0){
                $log = "订单取消原因: => $new_cancel_reason";
            }else{
                $old_cancel_reason = M('order_cancel_reason')->where(array('id'=>$cancel_reason_id))->getField('reason');
                $log = "订单取消原因: $old_cancel_reason=> {$new_cancel_reason}";
            }
            $_POST['id'] = $v;
            M('Order')->save($_POST);
            D('AdminLog')->addOrderLog($log,$v);
        }
        $this->redirect('Admin/Finance/cancel_order',array('pid'=>I('pid'),'p'=>I('p')));
    }
//在已结算订单列表里 批量退费
    function batch_return_money(){
        $_POST['lastupdate'] = session('admin_name');
        $_POST['return_fee'] = date('Y-m-d H:i:s',time());
        $_POST['status'] = 6;
        $_POST['order_status'] = 6;
        $id_arr = explode(',',I('str'));
        $log = "退费{$_POST['return_money']}元";
        foreach($id_arr as $v){
            $_POST['id'] = $v;
            M('Order')->save($_POST);
            D('AdminLog')->addOrderLog($log,$v);
        }
        $this->redirect('Admin/Finance/end_account',array('pid'=>I('pid'),'p'=>I('p')));
    }
}