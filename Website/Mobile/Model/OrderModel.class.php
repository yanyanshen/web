<?php
namespace Mobile\Model;
use Think\Model;
/*@yanyanshen
@param string $status 订单的状态
@ return array $order_info 订单信息
*/
class OrderModel extends Model{
    public function order_center($status){
        if($status){
            $where = array('o.userid'=>session('mid'),'o.status=s.id',"o.status = $status");
        }else{
            $where = array('o.userid'=>session('mid'),'o.status=s.id');
        }
        $order_info = $this->table('xueches_order o,xueches_order_status s')
            ->field('o.*,s.statusname,s.memberstatus,s.adminstatus,o.s_nickname')
            ->where($where)
            ->order('o.create_time desc')
            ->select();
        return $order_info;
    }
/*@yanyanshen
@param string $id 摸个订单的id
@param array 某个订单的详情*/
    public function order_center_details($id){
        $field = 'o.id,os.memberstatus,os.statusname,o.type,o.inform,o.ordcode,
                o.class_name,o.num,o.tel,o.school_id,o.price,o.status,o.create_time,
                o.s_type,o.s_nickname';
        $order_detail = $this->table('xueches_order o,xueches_order_status os')
            ->field($field)
            ->where(array('o.userid' => session('mid'), "o.id=$id",'o.status = os.id'))->find();
            $order_detail['picurl'] = M('school')->where(array('id' => $order_detail['school_id']))->getField('picurl');
            $order_detail['picname'] = M('school')->where(array('id' => $order_detail['school_id']))->getField('picname');
            $order_detail['order_user'] = M('order_user')->field('name,class_name,tel')
                ->where(array( "oid = $id"))->select();
            return $order_detail;
    }
/*@沈艳艳 手机端订单添加
*return $ordcode 新添加的订单信息
*/
    public function pay(){
        $class = M('trainclass')->where(array('id'=>I('class_id')))->field('name,wholeprice,advanceprice')->find();
        $cityname = session('city');
        $cityid = M('citys')->where("cityname = '$cityname'")->getField('id');
        if(session('mid')){
            $data['userid'] = session('mid');
        }else{
            $account = $_POST['tel'][0];
            $truename = $_POST['name'][0];
            $userid = M('user')->where(array('account'=>$account))->getField('id');
            if($userid){
                M('user')->where(array('account'=>$account))->save(array('truename'=>$truename));
                $data['userid'] = $userid;
            }else{
                $user['account'] = $account ;
                $user['truename'] = $truename;
                $user['address'] = trim(I('address'));
                $user['pass'] = md5($account);
                $user['ntime'] = time();
                $user['cityid'] = $cityid;
                $user['lastupdate'] = $truename;
                $user['phone'] = $account;
                $user['jz_type'] = $class['name'];
                $data['userid'] = M('user')->add($user);
            }
            session('mid',$data['userid']);
        }
        $data['ordcode'] = getordcode();
        $data['num'] = trim(I('num'));
        $data['create_time']=time();
        $info = M('school')->where(array('id'=>I('id')))->find();
        if($info['type'] == 'jx'){
            $data['order_type'] = 1;
            $data['s_type'] = 1;
        }elseif($info['type'] == 'jl'){
            $data['order_type'] = 2;
            $data['s_type'] = 2;
        }elseif($info['type'] == 'zd'){
            $data['order_type'] = 3;
            $data['s_type'] = 3;
        }
        $data['school_id'] = $info['id'];
        $data['s_nickname'] = $info['nickname'];
        $where = session('mobile_order_source');
        $mobile_order_source_id = M('OrderSource')->where(array('name' => array('like',"%$where%")))->getField('id');
        if(!$mobile_order_source_id){
            $mobile_order_source_id = M('OrderSource')->add(array('name' => session('name')));
        }
        $data['order_source'] = $mobile_order_source_id;//线上支付
        $data['status']=1;//付款状态
        $data['type']=trim(I('type'));
        $data['inform']=trim(I('inform'));
        $data['address']=trim(I('address'));
        $data['class_name']=$class['name'];
        $data['cityname'] = $cityid;
        $data['tel'] = $account;
        $data['countyname']='无';
        if(trim(I('type')) == 1){
            $data['price'] = $class['wholeprice'] * trim(I('num'));
        }elseif(trim(I('type')) == 2){
            $data['price'] = $class['advanceprice'] * trim(I('num'));
        }
        $this->startTrans();
        $oid = $this->add($data);
        $ordcode = $this->where("id = $oid")->find();
        if($oid){
            $this->commit();
            M('OrderSource')->where(array('id'=>17))->setInc('order_num',trim(I('num')));
            $data['oid'] = $oid;
            $data['num'] = 1;
            if(trim(I('type')) == 1){
                $data['price'] = $class['wholeprice'];
            }elseif(trim(I('type')) == 2){
                $data['price'] = $class['advanceprice'];
            }
            foreach($_POST['name'] as $k=>$v){
                $data['name'] = $v;
                $data['tel'] = $_POST['tel'][$k];
                M('order_user')->add($data);
            }
            $log['done'] = '订单创建';
            $log['url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $log['uid'] = session('mid');
            D('UserLog')->add_user_log($log);
        }else{
            $this->rollback();
        }
        return $ordcode;
    }
}