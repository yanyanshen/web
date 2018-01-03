<?php
namespace Admin\Model;
use Think\Model;
class OrderModel extends Model {
/*沈艳艳
    @param array $get 参数
    @param return excel倒出是否成功
    @param $flag 导出列表的类型
*/
    public function push($get){
        $where = '';
        $admin = M('Admin')->where(array('id'=>session('admin_id')))->find();
        if($admin['permissions'] != 1){//1可查看所有人的订单,其他只能查看自己的订单
            if($admin['authority'] == 0){
                $get['customer'] = session('admin_name');
            }elseif($admin['authority'] == 1){
                $authGroupAccess = M('AuthGroupAccess')->field('group_id')->where(array('uid'=>session('admin_id')))->select();
                foreach($authGroupAccess as $v){
                    $str .= $v['group_id'].',';
                }
                $str = M('AuthGroupAccess')->DISTINCT(true)->field('uid')->where(array('group_id'=>array('in',$str)))->select();
                foreach($str as $k => $v){
                    $username .= "'".M('Admin')->where(array('id'=>$v['uid']))->getField('username')."',";
                }
                $get['username'] = substr($username,0,-1);
            }
        }
        if(!empty($get)){
            foreach($get as $key=>$val) {
                if($key == 's_nickname' && $val != ''){
                    $where.=" o.s_nickname like '%".trim($get['s_nickname'])."%' and";
                }elseif($key == 'tel' && $val != ''){
                    $where.=" o.$key like '%".urldecode($val)."%' and";
                } elseif($key == 'order_type' && $val != 0){
                    $where.=" o.$key =".urldecode($val)." and";
                }elseif($key == 'ordcode' && $val != ''){
                    $where.=" o.$key like '%".urldecode($val)."%'".' and';
                }elseif($key == 'cityname' && $val != 0){
                    $where.=" o.$key =".urldecode($val)." and" ;
                }elseif($key == 'pay_type' && $val != 0){
                    $where.=" o.$key =".urldecode($val)." and";
                }elseif($key == 'customer' && $val != ''){
                    $where.=" o.$key like '%".trim($val)."%'".' and';
                }elseif($key == 'class_name' && $val != '0'){
                    $where.=" c.name like '%".trim($val)."%'".' and';
                }elseif($key == 'trainaddress' && $val != ''){
                    $where.=" ta.trname like '%".trim($val)."%'"." and";
                }elseif($key == 'create_time1' && $val != ''){//下单时间
                    $where.=" o.create_time  > '$val' and";
                }elseif($key == 'create_time2' && $val != ''){
                    $where.=" o.create_time  < '$val' and";
                }elseif($key == 'notify_time1' && $val != ''){//支付时间
                    $where.=" o.notify_time  > '$val' and";
                }elseif($key == 'notify_time2' && $val != ''){
                    $where.=" notify_time  < '$val' and";
                }elseif($key == 'return_time1' && $val != ''){//回访时间
                    $where.=" o.return_time  > '$val' and";
                }elseif($key == 'return_time2' && $val != ''){
                    $where.=" o.return_time  < '$val' and";
                }elseif($key == 'return_fee1' && $val != ''){//退款时间
                    $where.=" o.return_fee  >'$val' and";
                }elseif($key == 'return_fee2' && $val != ''){
                    $where.=" o.return_fee  <'$val' and";
                }elseif($key == 'cancel_reason' && $val != 0){//取消原因
                    $where.=" o.cancel_reason  = $val and";
                }elseif($key == 'cancel_time1' && $val != ''){//取消时间
                    $where.=" o.cancel_time  > '$val' and";
                }elseif($key == 'cancel_time2' && $val != ''){
                    $where.=" o.cancel_time  < '$val' and";
                }elseif($key == 'truename' && $val != ''){
                    $where.=" ou.name like '%".trim($val)."%'".' and';
                }elseif($key == 'end_time1' && $val != ''){//结算时间
                    $where.=" o.end_time  > '$val' and";
                }elseif($key == 'end_time2' && $val != ''){//结算时间
                    $where.=" o.end_time  < '$val' and";
                }elseif($key == 'orderStatus' && $val != 0){
                    $where.=" o.order_status  = $val and";
                }elseif($key == 'status' && $val == 2){//支付宝已支付未处理
                    $where.=" o.$key  = $val and";
                }elseif($key == 'order_status' && $val == 1){//未处理
                    $where.=" o.$key  = $val and";
                }elseif($key == 'order_status' && $val == 2){//待回访订单
                    $egt_time = date('Y-m-d 22:00:00',time());//当天晚上10以前的所有的订单
                    $where.=" o.$key  = $val and o.return_time <= '$egt_time' and";
                }elseif($key == 'order_status' && $val == 3){//待结算订单条件
                    $where.=" o.$key  = $val and";
                }elseif($key == 'order_status' && $val == 4){//已结算订单条件
                    $where.=" o.$key  = $val and";
                }elseif($key == 'order_status' && $val == 5){//已退款订单条件
                    $where.=" o.$key  = $val and";
                }elseif($key == 'order_status' && $val == 6){//已取消订单条件
                    $where.=" o.$key  = $val and";
                }elseif($key == 'username' && $val != ''){
                    $where.=" o.customer in ($val) and";
                }
            }$where=rtrim($where,'and');
        }
        $list = $this->alias('o')->join('xueches_trainclass c ON c.id=o.class_name')
            ->join('xueches_trainaddress ta ON ta.id=o.trainaddress')->where($where)
            ->field('o.*,ou.name,ou.tel,c.name as class_name,c.wholeprice,c.advanceprice,c.officeprice,ta.trname')
            ->join('xueches_order_user ou ON ou.oid=o.id')->select();
        foreach($list as $k=>$v){
            $list[$k]['cancel_reason'] = M('OrderCancelReason')->where(array('id'=>$v['cancel_reason']))->getField('reason');
        }
        $name='Excelfile';    //生成的Excel文件文件名
        $res = push($list,$name);
        return $res;
    }
    //设置下次回访日期
/*沈艳艳
    @param string $oid 订单编号
    @param string $id 订单的唯一id
    @param return 是否更新成功
*/
    public function returndate($oid,$id){
        $data['lastupdate'] = session('admin_name');
        $data['customer_inform'] = $_POST['content'];
        $data['return_time'] = $_POST['return_time'];
        $info = $this->field('status,order_status')->where(array('id'=>$id))->find();
        if($info['status']==1 || $info['order_status']==1){
            $data['order_status'] = 2;//待回访状态
        }

        $this->where(array('id'=>$id))->save($data);
        $customer['create_time'] = date('Y-m-d H:i:s');
        $customer['operator'] = session('admin_name');
        $customer['return_time'] = $_POST['return_time'];
        $customer['content'] = $_POST['content'];
        $customer['ordcode'] = $oid;
        if(M('customer')->add($customer)){
            $log = '给订单添加回访记录 ID_'.$id;
            D('AdminLog')->addOrderLog($log,$id);

            $message="<script>alert('更新成功')</script>";
        }else{
            $message="<script>alert('更新失败')</script>";
        }
        return $message;
    }
/*沈艳艳
  @param array $get 参数
  @param return 返回查询条件
*/
    public function order_list($get){
        $where = '';
        $admin = M('Admin')->where(array('id'=>session('admin_id')))->find();
        if($admin['permissions'] != 1){//1可查看所有人的订单,其他只能查看自己的订单
            if($admin['authority'] == 0){
                $get['customer'] = session('admin_name');
            }elseif($admin['authority'] == 1){
                $authGroupAccess = M('AuthGroupAccess')->field('group_id')->where(array('uid'=>session('admin_id')))->select();
                foreach($authGroupAccess as $v){
                    $str .= $v['group_id'].',';
                }
                $str = M('AuthGroupAccess')->DISTINCT(true)->field('uid')->where(array('group_id'=>array('in',$str)))->select();
                foreach($str as $k => $v){
                    $username .= "'".M('Admin')->where(array('id'=>$v['uid']))->getField('username')."',";
                }
                $get['username'] = substr($username,0,-1);
            }
        }
        if(!empty($get)){
            foreach($get as $key=>$val) {
                if($key == 's_nickname' && $val != ''){
                    $where.=" o.s_nickname like '%".trim($get['s_nickname'])."%' and";
                }elseif($key == 'tel' && $val != ''){
                    $where.=" o.$key like '%".urldecode($val)."%' and";
                } elseif($key == 'order_type' && $val != 0){
                    $where.=" o.$key =".urldecode($val)." and";
                }elseif($key == 'ordcode' && $val != ''){
                    $where.=" o.$key like '%$val%' and";
                }elseif($key == 'cityname' && $val != 0){
                    $where.=" o.$key =".urldecode($val)." and" ;
                }elseif($key == 'pay_type' && $val != 0){
                    $where.=" o.$key =".urldecode($val)." and";
                }elseif($key == 'customer' && $val != ''){
                    $where.=" o.$key like '%".trim($val)."%'".' and';
                }elseif($key == 'class_name' && $val != '0'){
                    $where.=" c.name like '%".trim($val)."%'".' and';
                }elseif($key == 'trainaddress' && $val != ''){
                    $where.=" ta.trname like '%".trim($val)."%'"." and";
                }elseif($key == 'create_time1' && $val != ''){//下单时间
                    $where.=" o.create_time  > '$val' and";
                }elseif($key == 'create_time2' && $val != ''){
                    $where.=" o.create_time  < '$val' and";
                }elseif($key == 'notify_time1' && $val != ''){//支付时间
                    $where.=" o.notify_time  > '$val' and";
                }elseif($key == 'notify_time2' && $val != ''){
                    $where.=" notify_time  < '$val' and";
                }elseif($key == 'return_time1' && $val != ''){//回访时间
                    $where.=" o.return_time  > '$val' and";
                }elseif($key == 'return_time2' && $val != ''){
                    $where.=" o.return_time  < '$val' and";
                }elseif($key == 'return_fee1' && $val != ''){//退款时间
                    $where.=" o.return_fee  >'$val' and";
                }elseif($key == 'return_fee2' && $val != ''){
                    $where.=" o.return_fee  <'$val' and";
                }elseif($key == 'cancel_reason' && $val != 0){//取消原因
                    $where.=" o.cancel_reason  = $val and";
                }elseif($key == 'cancel_time1' && $val != ''){//取消时间
                    $where.=" o.cancel_time  > '$val' and";
                }elseif($key == 'cancel_time2' && $val != ''){
                    $where.=" o.cancel_time  < '$val' and";
                }elseif($key == 'truename' && $val != ''){
                    $where.=" ou.name like '%".trim($val)."%' and";
                }elseif($key == 'end_time1' && $val != ''){//结算时间
                    $where.=" o.end_time  > '$val' and";
                }elseif($key == 'end_time2' && $val != ''){//结算时间
                    $where.=" o.end_time  < '$val' and";
                }elseif($key == 'orderStatus' && $val != 0){
                    $where.=" o.order_status  = $val and";
                }elseif($key == 'status' && $val == 2){//支付宝已支付未处理
                    $where.=" o.$key  = $val and";
                }elseif($key == 'order_status' && $val == 1){//未处理
                    $where.=" o.$key  = $val and";
                }elseif($key == 'order_status' && $val == 2){//待回访订单
                    $egt_time = date('Y-m-d 22:00:00',time());//当天晚上10以前的所有的订单
                    $where.=" o.$key  = $val and o.return_time <= '$egt_time' and";
                }elseif($key == 'order_status' && $val == 3){//待结算订单条件
                    $where.=" o.$key  = $val and";
                }elseif($key == 'order_status' && $val == 4){//已结算订单条件
                    $where.=" o.$key  = $val and";
                }elseif($key == 'order_status' && $val == 5){//已退款订单条件
                    $where.=" o.$key  = $val and";
                }elseif($key == 'order_status' && $val == 6){//已取消订单条件
                    $where.=" o.$key  = $val and";
                }elseif($key == 'username' && $val != ''){
                    $where.=" o.customer in ($val) and";
                }
            }$where=rtrim($where,'and');
        }

        $count = $this->alias('o')->join('xueches_trainclass c ON c.id=o.class_name')
            ->join('xueches_trainaddress ta ON ta.id=o.trainaddress')
            ->join('xueches_order_user ou ON ou.oid=o.id')
            ->where($where)->count();
        $p = new \Think\Page($count,10);
        $list = $this->alias('o')->join('xueches_trainclass c ON c.id=o.class_name')
            ->join('xueches_trainaddress ta ON ta.id=o.trainaddress')
            ->join('xueches_order_user ou ON ou.oid=o.id')->where($where)
            ->field('o.*,ou.name,ou.tel,c.name as class_name,c.wholeprice,c.advanceprice,c.officeprice,ta.trname')
            ->order('o.create_time desc')->limit($p->firstRow.','.$p->listRows)->select();

        foreach($list as $k=>$v){
            $list[$k]['cancel_reason'] = M('OrderCancelReason')->where(array('id'=>$v['cancel_reason']))->getField('reason');
        }
        $arr['list'] = $list;
        $arr['count'] = $count;
        $arr['page'] = $p->show();
        $arr['firstRow'] = $p->firstRow;
        return $arr;
    }
/*-----------------------------2017-11-23shenyanyan---------------------------*/
//支付宝已支付未处理、待回访、待结算待回访 数量
    public function order_count(){
        $admin = M('Admin')->where(array('id'=>session('admin_id')))->find();
        if($admin['permissions'] != 1){//1可查看所有人的订单,其他只能查看自己的订单
            if($admin['authority'] == 0){
                $where['customer'] = session('admin_name');
            }elseif($admin['authority'] == 1){
                $authGroupAccess = M('AuthGroupAccess')->field('group_id')->where(array('uid'=>session('admin_id')))->select();
                foreach($authGroupAccess as $v){
                    $str .= $v['group_id'].',';
                }
                $str = M('AuthGroupAccess')->DISTINCT(true)->field('uid')->where(array('group_id'=>array('in',$str)))->select();
                foreach($str as $k => $v){
                    $username .= M('Admin')->where(array('id'=>$v['uid']))->getField('username').",";
                }
                $where['customer'] = array('in',substr($username,0,-1));
            }
        }
        //用户在网上支付但后台客服未处理订单数量
        $where['order_status'] = 1;
        $count['count1'] = M('Order')->where(array('status'=>2,$where))->count();
        //待结算需回访
        $where['order_status'] = 3;
        $count['count3'] = M('Order')->where($where)->sum('num');
        //待回访订单数量
        $where['return_time'] = array('elt', date('Y-m-d 22:00:00',time()));//当天晚上10点半以前的所有订单
        $where['order_status'] = 2;
        $count['count2'] = M('Order')->where($where)->count();
        return $count;
    }
/*沈艳艳
  @param array $post 参数
  @param return 是否添加成功
*/
    public function update_class($post){
        //得到课程 id、基地 id、驾校名称
        $info = $this->where(array('id'=>$post['id']))->field('class_name,trainaddress,s_nickname')->find();
        //得到未改之前课程名称 基地名称
        $class_name = M('trainclass')->where("id = {$info['class_name']}")->getField('name');
        $trainaddress = M('trainaddress')->where("id = {$info['trainaddress']}")->getField('trname');

        //修改之后的课程、基地名称
        $class_name1 = M('trainclass')->where("id = {$post['class_name']}")->getField('name');
        $trainaddress1 = M('trainaddress')->where("id = {$post['trainaddress']}")->getField('trname');

        $log = "意向课程:{$info['s_nickname']} - {$class_name} - {$trainaddress} => {$post['s_nickname']} - {$class_name1} - {$trainaddress1}";

        $post['lastupdate'] = session('admin_name');
        $res = $this->save($post);
        if($res){
            $post['oid'] = $post['id'];
            unset($post['id']);
            M('OrderUser')->where(array('oid'=>$post['oid']))->save($post);
            if($log){
                D('AdminLog')->addOrderLog($log,$post['oid']);
            }
        }
        return $res;
    }
/*沈艳艳
  @param array $post 参数
  @param return 是否添加成功
*/
    public function add_order($post){
        $cityname = M('citys')->where("id = {$post['cityid']}")->getField('cityname');
        $userid = M('User')->where("account = {$post['phone']}")->getField('id');

        $order['address'] = $cityname.' '.$post['countyname'].' '.$post['address'];
        $order['s_nickname'] = $post['s_nickname'];
        $order['school_id'] = $post['school_id'];
        $order['trainaddress'] = $post['trainaddress'];
        $order['countyname'] = $post['countyname'];
        $order['cityname'] = $post['cityid'];
        $order['class_name'] = $post['class_name'];
        $order['pay_type'] = $post['pay_type'];
        $order['order_source'] = $post['order_source'];//订单来源
        $order['url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];//下单链接;
        //订单关键词  后台人工新建订单的话  关键词是 所报驾校
        $order_keyword_id = M('OrderKeyword')->where(array('name'=>$post['s_nickname']))->getField('id');
        if($order_keyword_id){
            $order['order_keyword'] = $order_keyword_id;
        }else{
            $order['order_keyword'] = M('OrderKeyword')->add($post['s_nickname']);
        }
        $order['customer_inform'] = $post['customer_inform'];
        $order['return_time'] = $post['return_time'];
        $order['create_time'] = date('Y-m-d H:i:s',time());
        if($userid){
            $order['userid'] = $userid;
        }else{
            $user['cityid'] = $post['cityid'];
            $user['truename'] = $post['truename'];
            $user['phone'] = $post['phone'];
            $user['account'] = $post['phone'];
            $user['pass'] = md5('517xueche');
            $user['ntime'] = time();
            $user['jz_type'] = M('trainclass')->where(array('id'=>$post['class_name']))->getField('name');
            $user['sex'] = $post['user_sex'];
            $user['address'] = $cityname.' '.$post['countyname'].' '.$post['address'];
            $order['userid'] = M('User')->add($user);
        }
        $order['tel'] = $post['phone'];
        $order['price'] = $post['price'];
        $order['ordcode'] = getordcode();
        $order['lastupdate'] = session('admin_name');
        $order['customer'] = session('admin_name');
        $order['num'] = count($post['account'])?(count($post['account'])+1):1;
        $order['price'] = $post['wholeprice'] * $order['num'];
        $order['name'] = $post['truename'];
        $order['sex'] = $post['user_sex'];

        $order['order_status'] = 2;
        $oid = $this->add($order);
        M('School')->where(array('id'=>$post['school_id']))->setInc('student_num',$order['num']);
        $order['oid'] = $oid;
        $order['price'] = $post['wholeprice'];

        M('order_user')->add($order);
        if($post['account']){
            $order['num'] = 1;
            for($i=0;$i<count($post['account']);$i++){
                $order['name'] = $post['account'][$i];
                $order['tel'] = $post['tel'][$i];
                $order['sex'] = $post['sex'][$i];
                M('order_user')->add($order);
                $log1 .= "{$post['account'][$i]}({$post['tel'][$i]}) | ";
            }
            $log = "学员信息:{$post['truename']}({$post['phone']}) | $log1 => {$post['truename']}({$post['phone']}) |$log1";
        }else{
            $log .= " 学员信息:{$post['truename']}({$post['phone']}) => {$post['truename']}({$post['phone']})";
        }
        if($oid){
            //添加回访记录
            $customer['ordcode'] = $order['ordcode'];
            $customer['create_time'] = date('Y-m-d H:i:s',time());
            $customer['content'] = $post['customer_inform'];
            $customer['operator'] = session('admin_name');
            $customer['return_time'] = $post['return_time'];
            M('customer')->add($customer);

            if($log){
                D('AdminLog')->addOrderLog($log,$oid);
            }
            $message="<script>alert('更新成功')</script>";
        }else{
            $message="<script>alert('更新失败')</script>";
        }
        return $message;
    }
/*
 * User: 沈艳艳
 * Date: 2017/08/22
 * Time: 16:38
 * 订单详情支付信息修改和确认订单
 * @param array $post 提交的数据
 */
    public function pay_type($post){
        //原有的支付方式
        $post['lastupdate'] = session('admin_name');
        $order = M('Order')->where(array('id'=>$post['id']))->find();
        if($order['pay_type'] == 0){
            $log = "支付方式:未支付 => ";
        }elseif($order['pay_type'] == 1){
            $log = "支付方式:支付宝 => ";
        }elseif($order['pay_type'] == 2){
            $log = "支付方式:微信 => ";
        }elseif($order['pay_type'] == 3){
            $log = "支付方式:门店 => ";
        }elseif($order['pay_type'] == 4){
            $log = "支付方式:快递 => ";
        }elseif($order['pay_type'] == 5){
            $log = "支付方式:驾校 => ";
        }
        if($post['pay_type'] == 0){
            $log .= '未支付';
        }elseif($post['pay_type'] == 1){
            $log .= '支付宝';
        }elseif($post['pay_type'] == 2){
            $log .= '微信';
        }elseif($post['pay_type'] == 3){
            $log .= '门店';
        }elseif($post['pay_type'] == 4){
            $log .= '快递';
        }elseif($post['pay_type'] == 5){
            $log .= '驾校';
        }
        $res = $this->save($post);
        if($res){
            return $log;
        }else{
            return 0;
        }
    }
/*
 * User: 沈艳艳
 * Date: 2017/08/22
 * 订单详情支付信息修改和确认订单
 * @param array $get 条件
 * @return array $order_source 返回订单来源数据
 */
    public function order_source($get){
        if(is_array($get)){
            foreach($get as $key=>$val) {
                if($key == 'create_time' && $val != ''){
                    $where.="  create_time >= '$val' and";
                }elseif($key == 'create_time1' && $val != ''){
                    $where.="  create_time  <= '$val' and";
                }
            }$where=rtrim($where,'and ');
        }
        $order_source = M('OrderSource')->select();
        foreach($order_source as $k=>$v){
            $order_source[$k]['order_num'] = $this->where(array('order_source'=>$v['id'], $where))->sum('num');//订单总量

            //成单量
            $order_source[$k]['completed_num'] = $this->where(array('order_source'=>$v['id'],"order_status = 3 and $where"))->sum('num');
            //成单率
            if($order_source[$k]['completed_num']){
                $order_source[$k]['completed_lv'] = sprintf('%.2f',$order_source[$k]['completed_num']/$order_source[$k]['order_num']*100).'%';
            }else{
                $order_source[$k]['completed_lv'] = 0;
            }


            //结算量
            $order_source[$k]['end_num'] = $this->where(array('order_source'=>$v['id'],"order_status = 4 and $where"))->sum('num');
            //结算率
            if($order_source[$k]['end_num']){
                $order_source[$k]['end_lv'] = sprintf('%.2f',$order_source[$k]['end_num']/$order_source[$k]['order_num']*100).'%';
            }else{
                $order_source[$k]['end_lv'] = 0;
            }


            $order_source[$k]['cancel_num'] = $this->where(array('order_source'=>$v['id'],'order_status'=>5, $where))->sum('num');
            if($order_source[$k]['cancel_num']){
                $order_source[$k]['cancel_lv'] = sprintf('%.2f',$order_source[$k]['cancel_num']/$order_source[$k]['order_num']*100).'%';
            }else{
                $order_source[$k]['cancel_lv'] = 0;
            }
        }
        return $order_source;
    }
/*------------------------------------------2017-11-06shenyanyan--------------------------------*/
//订单关键字
    public function order_keyword($get){
        if(is_array($get)){
            foreach($get as $key=>$val) {
                if($key == 'create_time' && $val != ''){
                    $where.=" create_time >= '$val' and";
                }elseif($key == 'create_time1' && $val != ''){
                    $where.=" create_time  <= '$val' and";
                }
            }$where=rtrim($where,'and ');
        }

        $order_source = M('OrderKeyword')->select();
        foreach($order_source as $k=>$v){
            $source_id = $this->where(array('order_keyword'=>$v['id']))->getField('order_source');//订单来源
            $order_source[$k]['source'] = M('OrderSource')->where(array('id'=>$source_id))->getField('name');//订单来源

            $order_source[$k]['order_num'] = $this->where(array('order_keyword'=>$v['id'], $where))->getField('num');//各个关键词订单总数量
            //各个关键词 已付款未结算
            $order_source[$k]['completed_num'] = $this->where(array('order_keyword'=>$v['id'],"order_status = 3 and $where"))->sum('num');
            if($order_source[$k]['completed_num']){
                $order_source[$k]['completed_lv'] = sprintf('%.2f',$order_source[$k]['completed_num']/$order_source[$k]['order_num']*100).'%';
            }else{
                $order_source[$k]['completed_lv'] = 0;
            }
            //结算量
            $order_source[$k]['end_num'] = $this->where(array('order_keyword'=>$v['id'],"order_status = 4 and $where"))->sum('num');
            //结算率
            if($order_source[$k]['end_num']){
                $order_source[$k]['end_lv'] = sprintf('%.2f',$order_source[$k]['end_num']/$order_source[$k]['order_num']*100).'%';
            }else{
                $order_source[$k]['end_lv'] = 0;
            }
            //取消总量
            $order_source[$k]['cancel_num'] = $this->where(array('order_keyword'=>$v['id'],'order_status'=>5, $where))->sum('num');
            //取消率
            if($order_source[$k]['cancel_num']){
                $order_source[$k]['cancel_lv'] = sprintf('%.2f',$order_source[$k]['cancel_num']/$order_source[$k]['order_num']*100).'%';
            }else{
                $order_source[$k]['cancel_lv'] = 0;
            }
        }
        return $order_source;
    }
/*
 * User: 沈艳艳
 * Date: 2017/08/24
 * @param $get array 条件
 * 订单统计报表
 * return array 返回查询数组
 */
    public function order_statistics($get){
        if(is_array($get)){
            foreach($get as $key=>$val) {
                if($key == 'create_time' && $val != ''){
                    $val = trim($val);
                    $where.=" create_time > '$val' and ";
                }elseif($key == 'create_time1' && $val != ''){
                    $val = trim($val);
                    $where.=" create_time  < '$val' and ";
                }elseif($key == 'cityname'  && $val != 0){
                    $where.=" $key  = $val and ";
                }
            }$where=rtrim($where,' and ');
        }
        $order_statistics['order_num'] = $this->where($where)->sum('num');//总订单量

        $order_statistics['completed_num'] = $this->where("order_status=3 and $where")->sum('num');//成单量（只要点击确认付款就计入）
        if($order_statistics['completed_num']){//成单量
            $order_statistics['completed_lv'] = sprintf('%.2f',$order_statistics['completed_num']/$order_statistics['order_num']*100).'%';
        }else{
            $order_statistics['completed_lv'] = 0;
        }

        $order_statistics['end_num'] = $this->where("order_status=4 and $where")->sum('num');//已结算订单量（只要点击结算就计入）
        if($order_statistics['end_num']){//结算率
            $order_statistics['end_lv'] = sprintf('%.2f',$order_statistics['end_num']/$order_statistics['order_num']*100).'%';
        }else{
            $order_statistics['end_lv'] = 0;
        }

        $order_statistics['zhifu'] = $this->where("status != 1 and status != 5 and pay_type = 1 and $where")->count('num');
        $order_statistics['weixin'] = $this->where("status != 1 and status != 5 and pay_type = 2 and $where")->count('num');
        $order_statistics['mendian'] = $this->where("status != 1 and status != 5 and pay_type = 3 and $where")->count('num');
        $order_statistics['kuaidi'] = $this->where("status != 1 and status != 5 and pay_type = 4 and $where")->count('num');
        $order_statistics['jiaxiao'] = $this->where("status != 1 and status != 5 and pay_type = 5 and $where")->count('num');
        return $order_statistics;
    }
}
