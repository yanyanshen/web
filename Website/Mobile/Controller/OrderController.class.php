<?php
namespace Mobile\Controller;
use Think\Controller;
class OrderController extends Controller{
    //订单填写页面
    public  function apply_order(){
        $name = M('trainclass')->where(array('id'=>I('sub_button')))->find();//我选了那个课程，用提交过来的课程id来查询课程名称
        $info = M('school')->where(array('id'=>$name['type_id']))->find();

        $this->assign('name',$name);
        $this->assign('nickname',$info['nickname']);
        $url=U('Mobile/Detail/index',array('id'=>$name['type_id'])).'#detail';
        $this->assign('url',$url);
        $this->assign('class_id',I('sub_button'));
        $this->display();
    }
    public function pay(){
        if(I('ordcode')){
            $order = M('Order');
            $ordcode = I('ordcode');
            $info = $order->where(array('ordcode'=>$ordcode))->find();
            $url = U('Mobile/User/order_center');
            $this->assign('ordcode',$ordcode);
            $this->assign('nickname',$info['s_nickname']);
            $this->assign('price',$info['price']);
        }else{
            $ordcode = D('order')->pay();
            $this->assign('ordcode',$ordcode['ordcode']);
            $this->assign('price',$ordcode['price']);
            $url = U('Mobile/Detail/index',array('id'=>I('id')));
            $this->assign('nickname',$ordcode['s_nickname']);
        }
        $this->assign('url',$url);
        $this->display();
    }
/*  支付类型判断  */
    public function pay_money(){
        switch($_POST['pay_way']){
            case 'alipay':
                $act = D('Pay');
                $data['pay_type'] = 1;
                M('order')->where(array('ordcode'=>$_POST['ordcode']))->save($data);
                $act->pay_money($_POST);
                break;
            case 'weixin'://微信支付
                $act = A('Wxpay');
//                $_POST['price'] = $_POST['price']*100;
                $_POST['price'] = 0.01*100;
                $act->index($_POST);
                break;
        }
    }
/*预约报名*/
    public function apply(){
        if(IS_AJAX){
            $data['truename']=$_POST['ap_name'];
            $data['phone']=$_POST['ap_tel'];
            $data['sex']=$_POST['ap_button'];
            $data['address']=$_POST['ap_position'];
            $data['inform']=$_POST['ap_message'];
            $data['ntime']=date('Y-m-d H:i:s',time());
            $data['mid']=session('mid');
            $id=M('apply')->add($data);
            if($id){
                $log['done'] = '订单预约';
                $log['url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                $log['uid'] = session('mid');
                D('UserLog')->add_user_log($log);
                $this->success('预约报名成功');
            }else{
                $this->error('预约失败');
            }
        }else{
            if(!session('mid')){
                $this->redirect('Mobile/Login/login');
            }else{
                $this->display();
            }
        }
    }

    /*订单状态*/
    public function confirm_order(){
        if(IS_AJAX){
            $order = M('order');
            $order->startTrans();
            if(I('status') == 1){//立即付款
                $ordcode = $order->where(array('id'=>I('oid')))->getField('ordcode');
                $res = 1;
                $url = U('Mobile/Order/pay?ordcode='.$ordcode);
            }elseif(I('status') == 3){//立即评价
                $res = 1;
                $url = U('Mobile/Evaluate/evaluate?oid='.I('oid'));
            }elseif(I('status') == 4){//追加评价
                $res = 1;
                $url = U('Mobile/Evaluate/evaluate_until?oid='.I('oid'));
            }elseif(I('status') == 5){//立即报名
                $res = $order->where(array('id'=>I('oid')))->getField('school_id');
                if($res){
                    $url = U('Mobile/Detail/index?id='.$res);
                }else{
                    $url = U('Mobile/List/pull');
                }
                $res = 1;
            }
            if($res){
                $order->commit();
                $this->success(1,$url);
            }else{
                $order->rollback();
                $this->error(0);
            }
            exit;
        }
        $this->display();
    }

}