<?php
namespace Admin\Model;
use Think\Model;
class OrderModel extends Model {
/*沈艳艳
  @param array $get 参数
    @param return excel倒出是否成功
*/
    public function push($get){
        $where = 'o.school_id = s.id';
        if(!empty($get)){
            foreach($get as $key=>$val) {
                if($key == 's_nickname' && $val != ''){
                    $where.=" and o.s_nickname like '%".trim($get['s_nickname'])."%'";
                }elseif($key == 'tel' && $val != ''){
                    $where.=" and o.$key like '%".urldecode($val)."%'";
                }elseif($key == 'status' && $val != 0){
                    $where.=" and o.$key = ".urldecode($val);
                }elseif($key == 'order_type' && $val != 0){
                    $where.=" and o.$key =".urldecode($val);
                }elseif($key == 'ordcode' && $val != ''){
                    $where.=" and o.$key like '%".urldecode($val)."%'";
                }elseif($key == 'cityname' && $val != 0){
                    $where.=" and o.$key =".urldecode($val);
                }elseif($key == 'pay_type' && $val != 0){
                    $where.=" and o.$key =".urldecode($val);
                }elseif($key == 'customer' && $val != ''){
                    $where.=" and o.$key like '%".trim($val)."%'";
                }elseif($key == 'class_name' && $val != '0'){
                    $where.=" and o.$key like '%".trim($val)."%'";
                }elseif($key == 'trainaddress' && $val != ''){
                    $where.=" and o.$key like '%".trim($val)."%'";
                }elseif($key == 'create_time1' && $val != ''){
                    $val = strtotime(trim($val));
                    $where.=" and o.create_time  > $val";
                }elseif($key == 'create_time2' && $val != ''){
                    $val = strtotime(trim($val));
                    $where.=" and o.create_time  < $val";
                }elseif($key == 'notify_time1' && $val != ''){
                    $where.=" and o.notify_time  > '$val'";
                }elseif($key == 'notify_time2' && $val != ''){
                    $where.=" and notify_time  < '$val'";
                }elseif($key == 'return_time1' && $val != ''){
                    $where.=" and o.return_time  > '$val'";
                }elseif($key == 'return_time2' && $val != ''){
                    $where.="  and o.return_time  < '$val'";
                }elseif($key == 'return_fee1' && $val != ''){
                    $where.=" and o.return_fee  >'$val'";
                }elseif($key == 'return_fee2' && $val != ''){
                    $where.=" and o.return_fee  <'$val'";
                }elseif($key == 'flag' && $val != ''){
                    $where.=" and o.flag  = $val";
                }elseif($key == 'visit' && $val != ''){
                    $where.=" and o.visit  = $val";
                }
            }
        }
        $field="o.id,o.ordcode,o.create_time,o.inform,o.status,o.pay_type,o.userid,o.return_time,o.class_name,
               o.lastupdate,o.order_type,o.pay_type,o.return_time,o.flag,s.nickname,o.userid,o.customer,
               o.trainaddress,o.tel,o.num,o.notify_time,o.customer_inform,o.create_time,o.return_time";
        $list = $this->table('xueches_order o,xueches_school s')
            ->where($where)
            ->field($field)
            ->order('id desc')
            ->select();
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
        $this->where(array('id'=>$id))->save(array('return_time'=>$_POST['return_time'],'customer'=>session('admin_name')));
        $customer['create_time'] = date('Y-m-d H:i:s');
        $customer['operator'] = session('admin_name');
        $customer['return_time'] = $_POST['return_time'];
        $customer['content'] = $_POST['content'];
        $customer['ordcode'] = $oid;
        if(M('customer')->add($customer)){
            $message="<script>alert('更新成功')</script>";
        }else{
            $message="<script>alert('更新失败')</script>";
        }
        return $message;
    }
/*沈艳艳
  @param array $get 参数
  @param return 返回查询条件
  @param $flag 条件
*/
    public function order_list($get,$flag=''){
        $where = '';
        if(!empty($get)){
            foreach($get as $key=>$val) {
                if($key == 's_nickname' && $val != ''){
                    $where.=" o.s_nickname like '%".trim($get['s_nickname'])."%' and";
                }elseif($key == 'tel' && $val != ''){
                    $where.=" o.$key like '%".urldecode($val)."%' and";
                }elseif($key == 'status' && $val != 0){
                    $where.=" o.$key = ".urldecode($val).' and';
                }elseif($key == 'order_type' && $val != 0){
                    $where.=" o.$key =".urldecode($val).' and';
                }elseif($key == 'ordcode' && $val != ''){
                    $where.=" o.$key like '%".urldecode($val)."%'".' and';
                }elseif($key == 'cityname' && $val != 0){
                    $where.=" o.$key =".urldecode($val).' and';
                }elseif($key == 'pay_type' && $val != 0){
                    $where.=" o.$key =".urldecode($val).' and';
                }elseif($key == 'customer' && $val != ''){
                    $where.=" o.$key like '%".trim($val)."%'".' and';
                }elseif($key == 'class_name' && $val != '0'){
                    $where.=" o.$key like '%".trim($val)."%'".' and';
                }elseif($key == 'trainaddress' && $val != ''){
                    $where.=" o.$key like '%".trim($val)."%'".' and';
                }elseif($key == 'create_time1' && $val != ''){
                    $where.=" o.create_time  > '$val' and";
                }elseif($key == 'create_time2' && $val != ''){
                    $where.=" o.create_time  < '$val' and";
                }elseif($key == 'notify_time1' && $val != ''){
                    $where.=" o.notify_time  > '$val' and";
                }elseif($key == 'notify_time2' && $val != ''){
                    $where.=" notify_time  < '$val' and";
                }elseif($key == 'return_time1' && $val != ''){
                    $where.=" o.return_time  > '$val' and";
                }elseif($key == 'return_time2' && $val != ''){
                    $where.=" o.return_time  < '$val' and";
                }elseif($key == 'return_fee1' && $val != ''){
                    $where.=" o.return_fee  >'$val' and";
                }elseif($key == 'return_fee2' && $val != ''){
                    $where.=" o.return_fee  <'$val' and";
                }elseif($key == 'flag' && $val != ''){
                    $where.=" o.flag  = $val and";
                }elseif($key == 'visit' && $val != ''){
                    $where.=" o.visit  = $val and";
                }
            }$where=rtrim($where,'and');
        }
        if($flag){
            if($where == ''){
                $where = $flag;
            }else{
                $where .= " and $flag";
            }
        }
        $count = $this->alias('o')->join('xueches_user u ON o.userid = u.id')->where($where)->count();
        $p = new \Think\Page($count,10);
        $list = $this->alias('o')->join('xueches_user u ON o.userid = u.id')
            ->where($where)
            ->field('o.*, u.truename')
            ->order('o.create_time desc')
            ->limit($p->firstRow.','.$p->listRows)->select();
        foreach($list as $k=>$v){
            $list[$k]['name'] = M('user')->where("id = {$v['userid']}")->getField('truename');
        }
        $page = $p->show();
        $arr['list'] = $list;
        $arr['count'] = $count;
        $arr['page'] = $page;
        $arr['firstRow'] = $p->firstRow;
        return $arr;
    }
/*沈艳艳
  @param array $post 参数
  @param return 是否添加成功
*/
    public function update_class($post){
        $log = '修改课程:'.$this->where(array('id'=>$post['id']))->getField('class_name').'=>';
        if($post['class_name']){
            $post['class_name'] = M('trainclass')->where("id = {$post['class_name']}")->getField('name');
            $log .= $post['class_name'];
        }else{
            $log .= 'C照全包';
        }
        $post['customer'] = session('admin_name');
        $post['lastupdate'] = session('admin_name');
        $res = $this->save($post);
        if($res){
            $post['oid'] = $post['id'];
            unset($post['id']);
            M('OrderUser')->where(array('oid'=>$post['oid']))->save($post);
            if($log){
                D('AdminLog')->addOrderLog($log);
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
        if($post['jx']){
            $order['school_id'] = $_POST['jx'];
            $order['s_type'] = 1;//0是驾校 1是教练 2是指导员
        }elseif($post['jl']){
            $order['school_id'] = $_POST['jl'];
            $order['s_type'] = 2;//0是驾校 1是教练 2是指导员
        }else if($post['zd']){
            $order['school_id'] = $_POST['zd'];
            $order['s_type'] = 3;
        }
        if($order['school_id']){
            $order['s_nickname'] = M('school')->where("id = {$order['school_id']}")->getField('nickname');
        }
        $order['address'] = $cityname.' '.$post['countyname'].' '.$post['address'];
        $order['trainaddress'] = $post['trainaddress'];
        $order['countyname'] = $post['countyname'];
        $order['cityname'] = $post['cityid'];
        $order['class_name'] = $post['class_name'];
        $order['type'] = $post['type'];
        $order['pay_type'] = $post['pay_type'];
        $order['order_source'] = $post['order_source'];
        $order['customer_inform'] = $post['customer_inform'];
        $order['return_time'] = $post['return_time'];
        $order['order_type'] = $post['order_type'];
        $order['create_time'] = time();
        if($userid){
            $order['userid'] = $userid;
            M('user')->where("id = $userid")->save(array('truename'=>$post['truename']));
        }else{
            $user['cityid'] = $post['cityid'];
            $user['truename'] = $post['truename'];
            $user['phone'] = $post['phone'];
            $user['account'] = $post['phone'];
            $user['pass'] = md5($post['phone']);
            $user['ntime'] = time();
            $user['lastupdate'] = session('admin_name');
            $user['sex'] = $post['user_sex'];
            $user['jz_type'] = $post['class_name'];
            $user['address'] = $cityname.' '.$post['countyname'].' '.$post['address'];
            $order['userid'] = M('User')->add($user);
        }
        $order['total_fee'] = $post['total_fee'];
        $order['tel'] = $post['phone'];
        $order['phone'] = $post['phone'];
        $order['ordcode'] = getordcode();
        $order['num'] = count($post['account'])?(count($post['account'])+1):1;
        $order['price'] = $post['price'] * $order['num'];
        $order['lastupdate'] = session('admin_name');
        $oid = $this->add($order);
        session('oid',$oid);
        $order['name'] = $post['truename'];
        $order['oid'] = $oid;
        $order['price'] = $post['price'];
        $log .= " 添加学员 name[0]: {$post['truename']}, tel:  {$post['phone']}; ";
        M('order_user')->add($order);
        if($post['account']){
            $order['num'] = 1;
            for($i=0;$i<count($post['account']);$i++){
                $order['name'] = $post['account'][$i];
                $order['tel'] = $post['tel'][$i];
                M('order_user')->add($order);
                $log .= "  name:[".($i+1)."] ".$post['account'][$i].", tel: ".$post['tel'][$i]." ; ";
            }
        }
        if($oid){
            $order_num = count($post['account'])?(count($post['account'])+1):1;
            M('OrderSource')->where(array('id'=>$_POST['order_source']))->setInc('order_num',$order_num);
            if($log){
                D('AdminLog')->addOrderLog($log);
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
    public function zhifu($post){
        $info = $this->where(array('id'=>$post['id']))->find();
        $price = $info['price']-$post['price'];
        if($price>0){
            $post['sale_price'] = $price;
        }else{
            $post['sale_price'] = 0;
        }
        $post['lastupdate'] = session('admin_name');
        if($post['pay_type'] == 0){
            $pay_type = '未支付';
        }elseif($post['pay_type'] == 1){
            $pay_type = '支付宝';
        }elseif($post['pay_type'] == 2){
            $pay_type = '微信';
        }elseif($post['pay_type'] == 3){
            $pay_type = '门店';
        }
        if($post['pay_address'] == 0){
            $pay_address = '无';
        }elseif($post['pay_address'] == 1){
            $pay_address = '手机端';
        }elseif($post['pay_address'] == 2){
            $pay_address = 'PC端';
        }elseif($post['pay_address'] == 3){
            $pay_address = '门店';
        }elseif($post['pay_address'] == 4){
            $pay_address = '其他';
        }
        $res = $this->save($post);
        if($res){
            $log = '修改支付方式/地点:'.$pay_type.'=>'.$pay_address .'; 修改金额=>'.$post['price'];
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
                    $val = strtotime(trim($val));
                    $where.="  create_time > $val and";
                }elseif($key == 'create_time1' && $val != ''){
                    $val = strtotime(trim($val));
                    $where.="  create_time  < $val and";
                }
            }$where=rtrim($where,'and ');
        }
        $order_source = M('OrderSource')->select();
        foreach($order_source as $k=>$v){
            $order_source[$k]['order_num'] = $this->where(array('order_source'=>$v['id'], $where))->sum('num');
            $order_source[$k]['completed_num'] = $this
                ->where(array('order_source'=>$v['id'],"status != 1 and status != 5 and $where"))
                ->sum('num');
            if($order_source[$k]['completed_num']){
                $order_source[$k]['completed_lv'] = sprintf('%.2f',$order_source[$k]['completed_num']/$order_source[$k]['order_num']*100).'%';
            }else{
                $order_source[$k]['completed_lv'] = 0;
            }
            $order_source[$k]['cancel_num'] = $this->where(array('order_source'=>$v['id'],'status'=>5, $where))->sum('num');
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
                    $val = strtotime(trim($val));
                    $where.=" create_time > $val and";
                }elseif($key == 'create_time1' && $val != ''){
                    $val = strtotime(trim($val));
                    $where.=" create_time  < $val and";
                }elseif($key == 'cityname'){
                    $where.=" $key  = $val and";
                }
            }$where=rtrim($where,'and');
        }
        $order_statistics['order_num'] = $this->where($where)->count('num');
        $order_statistics['completed_num'] = $this->where("status != 1 and status != 5 and $where")->count('num');
        if($order_statistics['completed_num']){
            $order_statistics['completed_lv'] = sprintf('%.2f',$order_statistics['completed_num']/$order_statistics['order_num']*100).'%';
        }else{
            $order_statistics['completed_lv'] = 0;
        }
        $order_statistics['pay_type'] = $this->where("status != 1 and status != 5 and pay_type = 1 and $where")->count('num');
        return $order_statistics;
    }
}
