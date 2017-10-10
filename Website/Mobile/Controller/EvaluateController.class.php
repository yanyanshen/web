<?php
namespace Mobile\Controller;
use Think\Controller;
use Mobile\Common\Controller\CommonController;
class EvaluateController extends CommonController{
/*评价*/
    public function evaluate(){
        if(IS_AJAX){
            if($_POST['content'] == '请输入评价信息' || $_POST['content'] == ''){
                $this->error('请输入评价信息');
            }elseif(!$_POST['score']){
                $this->error('请选择星级评分');
            }else{
                $_POST['content'] = filter_string($_POST['content']);
                $_POST['uid'] = session('mid');
                $_POST['ntime'] = date('Y-m-d');
                $_POST['sid'] = M('order')->where(array('id'=>$_POST['oid']))->getField('school_id');
                $_POST['lastip'] = I("server.REMOTE_ADDR");
                M('Evaluate')->startTrans();
                $last_id = M('Evaluate')->add($_POST);
                if($last_id){
                    M('Evaluate')->commit();
                    M('Order')->where(array('id'=>$_POST['oid']))->save(array('status'=>4));
                    $log['done'] = '订单评价';
                    $log['url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                    $log['uid'] = session('mid');
                    D('UserLog')->add_user_log($log);
                    M('school')->where(array('id'=>$_POST['sid']))->setInc('evalutioncount',1);
                    $this->success('评价成功',U('Mobile/User/order_center'));
                }else{
                    M('Evaluate')->rollback();
                    $this->error('网络连接失败，请稍后再试');
                }
            }
        }
        $oid = I('get.oid');
        $this->assign('oid',$oid);
        $this->display();
    }
/*追加评价*/
    public function evaluate_until(){
        if(IS_AJAX){
            if(IS_AJAX){
                if($_POST['content'] == '请输入追加信息' || $_POST['content'] == ''){
                    $this->error('请输入追加信息');
                }else{
                    $_POST['content'] = filter_string($_POST['content']);
                    $_POST['ntime'] = date('Y-m-d');
                    $_POST['lastip'] = I("server.REMOTE_ADDR");
                    M('EvaluateUntil')->startTrans();
                    $last_id = M('EvaluateUntil')->add($_POST);
                    if($last_id){
                        M('EvaluateUntil')->commit();
                        M('Evaluate')->where(array('id'=>$_POST['eid']))->save(array('append'=>1));
                        M('Order')->where(array('id'=>$_POST['oid']))->save(array('status'=>6));
                        $log['done'] = '追加评价';
                        $log['url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                        $log['uid'] = session('mid');
                        D('UserLog')->add_user_log($log);
                        $this->success('评价成功',U('Mobile/User/order_center'));
                    }else{
                        M('EvaluateUntil')->rollback();
                        $this->error('网络连接失败，请稍后再试');
                    }
                }
            }
        }
        $oid = I('get.oid');
        $info = M('evaluate')->where(array('uid'=>session('mid'),'oid'=>$oid))->find();
        $this->assign('oid',$oid);
        $this->assign('info',$info);
        $this->display();
    }
}
