<?php
namespace Mobile\Model;
use Think\Model;
/*@yanyanshen
@param string $status 订单的状态
@ return array $order_info 订单信息
*/
class OrderModel extends Model{
    public function order_center1($status){
        if($status){
            $where = array('o.userid'=>session('mid'),'o.status=s.id',"o.status = $status");
        }else{
            $where = array('o.userid'=>session('mid'),'o.status=s.id');
        }
        $order_info = $this->table('xueches_order o,xueches_order_status s')
            ->field('o.*,s.statusname,s.memberstatus,s.adminstatus,o.s_nickname')
            ->where($where)->order('o.create_time desc')->select();
        foreach($order_info as $k=>$v){
            $order_info[$k]['class_name'] = M('trainclass')->where(array('id'=>$v['class_name']))->getField('name');
            $order_info[$k]['s_type'] = M('school')->where(array('id'=>$v['school_id']))->getField('type');
        }
        return $order_info;
    }

    public function order_center($status,$post = ''){
        if($status){
            $where = array('userid'=>session('mid'),'status'=>$status);
        }else{
            $where = array('userid'=>session('mid'));
        }
        $num = 10;
        $page = $post['page']?$post['page']:1;
        $order_info = $this->field('id,status,s_nickname,class_name,type,price,total_fee,create_time,school_id')
            ->where($where)->page($page,$num)->order('create_time desc')->select();
        foreach($order_info as $k=>$v){
            $order_info[$k]['class_name'] = M('trainclass')->where(array('id'=>$v['class_name']))->getField('name');
            $order_info[$k]['s_type'] = M('school')->where(array('id'=>$v['school_id']))->getField('type');
        }
        return $order_info;
    }
/*@yanyanshen
@param string $id 摸个订单的id
@param array 某个订单的详情*/
    public function order_center_details($id){
        $field = 'id,type,inform,ordcode,class_name,num,tel,school_id,price,status,create_time,s_nickname';
        $order_detail = $this->field($field)
            ->where(array('userid' => session('mid'), 'id'=>$id))->find();
            $order_detail['picurl'] = M('school')->where(array('id' => $order_detail['school_id']))->getField('picurl');
            $order_detail['picname'] = M('school')->where(array('id' => $order_detail['school_id']))->getField('picname');
            $order_detail['order_user'] = M('order_user')->field('name,tel')->where(array( "oid = $id"))->select();
        $order_detail['class_name'] = M('trainclass')->where(array('id'=>$order_detail['class_name']))->getField('name');
            return $order_detail;
    }
/*@沈艳艳 手机端订单添加
*return $ordcode 新添加的订单信息
*/
    public function add_order(){
        $class = M('trainclass')->where(array('id'=>I('class_id')))->field('name,wholeprice,advanceprice,type_id')->find();
        $cityname = session('city');
        $cityid = M('citys')->where("cityname = '$cityname'")->getField('id');
        if(session('mid')){
            $data['userid'] = session('mid');
        }else{
            $userid = M('user')->where(array('account'=>I('phone')))->getField('id');
            if($userid){
                $data['userid'] = $userid;
            }else{
                $user['account'] = I('phone') ;
                $user['truename'] = I('account');
                $user['address'] = trim(I('address'));
                $user['pass'] = md5('517xueche');
                $user['ntime'] = time();
                $user['cityid'] = $cityid;
                $user['lastupdate'] = $_POST['account'];
                $user['phone'] = I('phone');
                $user['sex'] = I('sex');
                $user['jz_type'] = $class['name'];
                $data['userid'] = M('user')->add($user);
                M('School')->where(array('id'=>$class['type_id']))->setInc('student_num',1);
            }
            session('mid',$data['userid']);
        }
        $data['ordcode'] = getordcode();
        $data['num'] = trim(I('num'));
        $data['create_time']=date('Y-m-d H:i:s',time());
        $info = M('school')->where(array('id'=>I('id')))->find();
        $data['school_id'] = I('id');
        $data['sex'] = I('sex');
        $data['name'] = I('account');
        $data['s_nickname'] = $info['nickname'];
        $where = session('mobile_order_source');
        $mobile_order_source_id = M('OrderSource')->where(array('name' => array('like',"%$where%")))->getField('id');
        if(!$mobile_order_source_id){
            $mobile_order_source_id = 17;
        }
        $data['order_source'] = $mobile_order_source_id;//订单来源
        $data['status']=1;//付款状态
        $data['order_type']=2;//订单类型：在线订单
        $data['type']=trim(I('type'));//类型
        $data['inform']=trim(I('inform'));//订单备注
        $data['address']=trim(I('address'));//订单地址
        $data['class_name']=I('class_id');//课程id
        $data['cityname'] = $cityid;//地址
        $data['tel'] = $_POST['phone'];//联系电话
        if(trim(I('type')) == 1){
            $data['price'] = $class['wholeprice'] * trim(I('num'));//付款金额
        }elseif(trim(I('type')) == 2){
            $data['price'] = $class['advanceprice'] * trim(I('num'));
        }
        $this->startTrans();
        $oid = $this->add($data);
        if($oid){
            $this->commit();
            $data['oid'] = $oid;
            $data['num'] = 1;
            M('order_user')->add($data);

            if(trim(I('type')) == 1){
                $data['price'] = $class['wholeprice'];
            }elseif(trim(I('type')) == 2){
                $data['price'] = $class['advanceprice'];
            }
            if(!empty($_POST['name'])){
                foreach($_POST['name'] as $k=>$v){
                    $data['name'] = $v;
                    $data['tel'] = $_POST['tel'][$k];
                    M('order_user')->add($data);
                }
            }
            $log['done'] = '订单创建';
            $log['url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $log['uid'] = session('mid');
            D('UserLog')->add_user_log($log);
        }else{
            $this->rollback();
        }
        return $oid;
    }
}