<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Controller\CommonController;
class OrderController extends CommonController {
/*
 * User: 沈艳艳
 * Date: 217/08/25
 * 订单列表
*/
   public function order_list(){
//判断是否有新建订单权限
       $pid = I('pid');
       $add_order = D('AuthRule')->getRule($pid,'新建订单');
       $this->assign('add_order',$add_order);
//判断是否有订单列表处理按钮权限
       $list_info = D('AuthRule')->getRule($pid,'订单处理');
       $this->assign('list_info',$list_info);
       $this->assign('pid',$pid);

       $arr= D('order')->order_list($_GET);
       $citys=D('citys')->city_one("flag=1","id,cityname",1);
       $this->assign('citys', $citys);
       $this->assign('count', $arr['count']);
       $this->assign('page', $arr['page']);
       $this->assign('list', $arr['list']);
       $this->assign('firstRow', $arr['firstRow']);
       //未处理订单数量
       $count1 = M('Order')->where(array('flag'=>0))->count();
       //未回访订单数量
       $count2 = M('Order')->where(array('visit'=>0))->count();
       $this->assign('count1',$count1);
       $this->assign('count2',$count2);
       $this->assign('get',$_GET);
       $this->display();
   }
/*
 * User: 沈艳艳
 * Date: 2017/08/25
 * 已支付未处理订单
*/
    public function pay_list(){
        $where = ' flag = 0 and status != 1 and status != 5';
        $arr = D('order')->order_list($_GET,$where);
        $citys = D('citys')->city_one("flag=1","id,cityname",1);
        $this->assign('citys', $citys);
        $this->assign('count', $arr['count']);
        $this->assign('page', $arr['page']);
        $this->assign('list', $arr['list']);
        $this->assign('firstRow', $arr['firstRow']);
        $this->assign('get',$_GET);
        //未处理订单数量
        $count1 = M('Order')->where(array('flag'=>0))->count();
        //未回访订单数量
        $count2 = M('Order')->where(array('visit'=>0))->count();
        $this->assign('count1',$count1);
        $this->assign('count2',$count2);
        $this->display();
    }
/*
 * User: 沈艳艳
 * Date: 2017/08/25
 * 新建订单
 */
    function add_order(){
        //城市
        $citys=D('citys')->city_one("flag=1","id,cityname",1);
        if(isset($_REQUEST['cityid'])){
            $cityid=$_REQUEST['cityid'];
            $info=D('citys')->city_one(array('id'=>$_REQUEST['cityid']),'cityname');
            $this->assign('cityname',$info['cityname']);
        }else{
            $cityid=$citys[0]['id'];
            $this->assign('cityname',$citys[0]['cityname']);
        }

        $county=D('countys')->Countys_list("cityid=$cityid","id,countyname",1);
        $this->assign("countys",$county);
        $this->assign('citys',$citys);
        if(!empty($_POST)){
            $message = D('Order')->add_order($_POST);
            $this->redirect("add_order",'',0.1,$message);
        }
        $school = M('school s')->field("s.id,s.nickname,c.cityname")->where("type = 'jx'")->join("xueches_citys c on c.id=s.cityid")->select();
        $this->assign('school',$school);

        $coach = M('school s')->field("s.id,s.nickname,c.cityname")->where("type = 'jl'")->join("xueches_citys c on c.id=s.cityid")->select();
        $this->assign('coach',$coach);

        $guider = M('school s')->field("s.id,s.nickname,c.cityname")->where("type = 'zd'")->join("xueches_citys c on c.id=s.cityid")->select();
        $this->assign('guider',$guider);

        $order_source = M('OrderSource')->select();
        $this->assign('order_source',$order_source);
        $this->display();
    }
/*
 * User: 沈艳艳
 * Date: 217/08/25
 * 订单详情
 */
    public function list_info($id){
//日志操作查看权限
        $pid = I('pid');
        $this->assign('pid',$pid);
        $order_log = D('AuthRule')->getRule($pid,'日志操作');
        $this->assign('order_log',$order_log);
//修改学员信息权限
        $stu_update = D('AuthRule')->getRule($pid,'修改学员信息');
        $this->assign('stu_update',$stu_update);

//确认课程修改权限
        $class_update = D('AuthRule')->getRule($pid,'确认课程修改');
        $this->assign('class_update',$class_update);

        session('oid',$id);
        $field='id,ordcode,order_type,status,return_time,create_time,pay_type,tel,address,lastupdate,pay_address,
        s_nickname,class_name,trainaddress,price,total_fee,customer,userid,inform,num,type,school_id,connect,
        order_source,sale_price';
        //跟单所以客服
        $customers = M('admin')->field('id,username')->select();
        //订单详情
        $list = M('order')->field($field)->where("id=$id")->find();
        $this->assign("list",$list);

        //客户姓名/电话
        $user = M("user")->field("truename,account")->where("id='{$list['userid']}'")->find();
        $this->assign("user",$user);

        //学员姓名电话
        $stu = M('OrderUser')->field('name,tel')->where("oid = $id")->select();
        $this->assign('stu',$stu);
        //跟单记录
        $jilu = M('customer')->field("id,create_time,content,return_time,operator")->where("ordcode='{$list['ordcode']}'")->order("id desc")->limit(5)->select();
        //所报课程的全款价，全包价
        if($list['school_id']){
            $class = M('trainclass')->field("name,id")->where("type_id={$list['school_id']}")->select();
            $price= M('trainclass')->field("officeprice,wholeprice,advanceprice,(wholeprice-advanceprice) as whole1")->where("name='{$list['class_name']}' and type_id = {$list['school_id']}")->find();
        }else{
            $class = 0;
            $price = 0;
        }
        if($list['type'] == 1){
            session('price',$price['wholeprice']);
        }elseif($list['type'] == 2){
            session('price',$price['advanceprice']);
        }
        $train = M('train')->field("trainaddress_id")->where("type_id='{$list['school_id']}'")->find();
        if($train){
            $train = M("trainaddress")->field("id,trname")->where("id in ({$train['trainaddress_id']})")->select();
        }
        $order_source = M('OrderSource')->where(array('id'=>$list['order_source']))->getField('name');
        $this->assign("order_source",$order_source);
        $this->assign("price",$price);
        $this->assign("class",$class);
        $this->assign("train",$train);
        $this->assign("jilu",$jilu);
        $this->assign("id",$id);
        $this->assign("customers",$customers);
        $this->display();
    }
/*
 * User: 沈艳艳
 * Date: 2017/8/21
 * Time: 13:17
 * 订单详情的订单日志查看
 */
    public function order_log(){
        $order_log = D('AdminLog')->order_log();
        $this->assign('order_log',$order_log);
        $this->assign('empty',"<h>暂无操作日志</h>");
        $this->display();
    }
/*
 * User: 沈艳艳
 * Date: 2017/08/21
 * Time: 14:39
 * 订单详情修改课程意向页面
 */
    public function update_class(){
        if(IS_AJAX){
            $res = D('Order')->update_class($_POST);
            if($res){
                $this->success(1,U('Admin/Order/list_info',array('id'=>$_POST['id'],'pid'=>$_POST['pid'])));
            }else{
                $this->error();
            }
        }
    }
/*
 * User: 沈艳艳
 * Date: 2017/08/25
 * 订单详情返回基地、课程
 */
    function returntrain(){
        $json=file_get_contents("php://input");
        $obj = json_decode($json);
        $id = $obj->id;
        $data['trainclass'] = M("trainclass")->field("id,name")->where("type_id='$id'")->select();
        $train = M('train')->field("trainaddress_id")->where("type_id='$id'")->find();
        if($train){
            $data['train'] = M("trainaddress")->field("id,trname")->where("id in ({$train['trainaddress_id']})")->select();
        }else{
            $data=array();
        }
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $data[$key][$k] = $v;
                }
            }
        }
       echo stripslashes(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

/*
 * User: 沈艳艳
 * Date: 2017/08/25
 * 订单详情支付
 */
    public function zhifu(){
        if($_GET['t'] == 1){
            $log = '确认收款：'.$_POST['price'].'元';
            $info = M('Order')->field('order_source,num')->where(array('id'=>$_POST['id']))->find();
            M('OrderSource')->where(array('id'=>$info['order_source']))->setInc('completed_num',$info['num']);
            $res = M('Order')->where(array('id'=>$_POST['id']))->save(array('status'=>3,'lastupdate'=>session("admin_name"),'notify_time'=>date('Y-m-d H:i:s')));
        }else{
            $log = D('Order')->zhifu($_POST);
            $res = $log;
        }
        if($res){
            D('AdminLog')->addOrderLog($log);
            $this->redirect("list_info",array('id'=>$_POST['id'],'pid'=>$_POST['pid']),0.1,"<script>alert('更新成功')</script>");
        }else{
            $this->redirect("list_info",array('id'=>$_POST['id'],'pid'=>$_POST['pid']),0.1,"<script>alert('未做修改')</script>");
        }
    }
/*
 * User: 沈艳艳
 * Date: 2017/08/25
 * 订单详情修改学员信息并可以添加学员
 */
    public function stu_update(){
        if(IS_AJAX){
            //保存地址和备注
            M('Order')->where(array('id'=>session('oid')))->save(array('address'=>I('post.address'),'inform'=>I('post.inform')));
            //保存原有的学员信息 并添加日志
            $tel = I('post.tel');
            $id = I('post.id');
            if($tel){
                foreach(I('post.name') as $k=>$v){
                    $OrderUser['name'] = $v;
                    $OrderUser['tel'] = $tel[$k];
                    $OrderUser['sex'] = I('sex')[$k];
                    if(!M('OrderUser')->where($OrderUser)->getField('id')){
                        $OrderUser['lastupdate'] = session('admin_name');
                        M('OrderUser')->where(array('id'=>$id[$k]))->save($OrderUser);
                        $log .= " name/tel[$k]: $v($tel[$k]); ";
                    }
                }
                if($log){
                    $log = " 编辑学员:".$log;
                }
            }
            //添加新学员时添加日志
            $phone = I('post.phone');
            if(!empty($phone)){
                foreach(I('post.username') as $k1=>$v1){
                    $data['oid'] = session('oid');
                    $data['name']= $v1;
                    $data['tel'] = $phone[$k1];
                    $data['lastupdate'] = session("admin_name");
                    $data['sex'] = I('sex1')[$k];
                    $data['price'] = session('price')?session('price'):100;
                    $info = M('OrderUser')->add($data);
                    $log .= " name/tel[$k1]: $v1($phone[$k1]); ";
                }
                M('Order')->where(array('id'=>session('oid')))->setInc('num',count($phone));
                $log = "添加学员:".$log;
            }
            $price = M('OrderUser')->field('price')->where(array('oid'=>session('oid')))->sum('price');
            M('Order')->where(array('id'=>session('oid')))->save(array('price'=>$price));
            if($log){
                $res = D('AdminLog')->addOrderLog($log);
            }
            if($res){
                $this->success();
            }else{
                $this->error();
            }
        }else{
            $order_user = M('OrderUser')->where("oid=".session('oid'))->select();
            $info = M('Order')->field('address,inform')->where(array('id'=>session('oid')))->find();
            $this->assign('order_user',$order_user);
            $this->assign('info',$info);
            $this->display();
        }
    }
/*
 * User: 沈艳艳
 * Date: 2017/08/25
 * 订单列表到处excel表
 */
    public function push(){
        $res = D('Order')->push($_GET);
        $this->success($res);
    }
/*
 * User: 沈艳艳
 * Date: 2017/08/25
 * 订单详情设置下次回访日期
 */
    public function returndate(){
        $oid = $_POST['ordcode'];
        $id = $_POST['id'];
        $message = D('Order')->returndate($oid,$id);
        $this->redirect("list_info",array('id'=>I('id')),0.1,$message);
    }
/*
 * User: 沈艳艳
 * Date: 20174/08/25
 * @param string $id 订单id
 * 订单详情删除学员
 */
    public function del($id){
        $name = M('OrderUser')->where("id = $id")->getField('name');
        $log .= "删除学员 name: ".$name;
        $res = M('OrderUser')->where("id = $id")->delete();
        if($res){
            $count = M('OrderUser')->where(array('oid'=>session('oid')))->count();
            if(!$count){
                M('Order')->where(array('id'=>session('oid')))->delete();
            }else{
                M('Order')->where(array('id'=>session('oid')))->setDec('num',1);
                $price = M('OrderUser')->field('price')->where(array('oid'=>session('oid')))->sum('price');
                M('Order')->where(array('id'=>session('oid')))->save(array('price'=>$price));
            }
            $res = D('AdminLog')->addOrderLog($log);
            if($res){
                $this->success();
            }else{
                $this->error();
            }
        }else{
            $this->error();
        }
    }

//订单详情返回价格
    function returnprices($class_name){
        $data=M('trainclass')->field("id,officeprice,wholeprice,advanceprice,(wholeprice-advanceprice) as whole1")->where("id='$class_name'")->find();
        echo stripslashes(json_encode($data, JSON_UNESCAPED_UNICODE));
    }
//取消订单
    public function cencel_order($id,$pid){
        if(M('order')->where("id=$id")->setField(array('status'=>5,'return_fee'=>date('Y-m-d'),'notify_time'=>date('Y-m-d')))){
            $message="<script>alert('取消成功')</script>";
        }else{
            $message="<script>alert('取消失败')</script>";
        }
        $this->redirect("list_info",array('id'=>$id,'pid'=>$pid),0,$message);
    }
/*
 * User: 沈艳艳
 * Date: 2017/08/24
 * 订单统计
 */
    public function order_statistics(){
        $city = D('citys')->city_one('flag = 1','cityname,id',1);
        $this->assign('cityname',$_GET['cityname']);
        $this->assign('city',$city);

        if(!$_GET['create_time']){
            $_GET['create_time'] = date('Y-m-01');
            $_GET['create_time1'] = date('Y-m-d',strtotime("{$_GET['create_time']} + 1 month - 1 day"));
        }
        $order_statistics = D('Order')->order_statistics($_GET);
        $this->assign('order_statistics',$order_statistics);

        $this->assign('create_time',$_GET['create_time']);
        $this->assign('create_time1',$_GET['create_time1']);
        $this->display();
    }
/*
* User: 沈艳艳
* Date: 2017/08/23
* 订单来源报表展示
*/
    public function order_source(){
        if(!$_GET['create_time']){
            $_GET['create_time'] = date('Y-m-01', strtotime(date("Y-m-d")));
        } else{
            if($_GET['t'] == 1){
                $_GET['create_time'] = date('Y-m-01', strtotime('-1 month'));
                $_GET['create_time1'] = date('Y-m-t', strtotime('-1 month'));
            }
        }
        $this->assign('create_time',$_GET['create_time']);
        $this->assign('create_time1',$_GET['create_time1']);
        $order_source = D('Order')->order_source($_GET);
        $this->assign('order_source',$order_source);
        $this->assign('empty',"<h1>暂无数据</h1>");
        $this->assign('count',count($order_source));
        $order_num = 0;
        $completed_num = 0;
        $completed_lv = 0;
        $cancel_num = 0;
        foreach($order_source as $v){
            $order_num = $order_num + $v['order_num'];
            $completed_num = $completed_num + $v['completed_num'];
            if($completed_num){
                $completed_lv = $completed_num.'/'.$order_num.' = '.sprintf('%.2f',$completed_num/$order_num*100).'%';
            }
            $cancel_num = $cancel_num + $v['cancel_num'];
            if($cancel_num){
                $cancel_lv = $cancel_num.'/'.$order_num.' = '.sprintf('%.2f',$cancel_num/$order_num*100).'%';
            }
        }

        $this->assign('order_num',$order_num);
        $this->assign('completed_num',$completed_num);
        $this->assign('completed_lv',$completed_lv);
        $this->assign('cancel_num',$cancel_num);
        $this->assign('cancel_lv',$cancel_lv);
        $this->display();
    }
/*
 * User: 沈艳艳
 * Date: 207/08/24
 * 订单关键词来源统计
*/
    public function order_keyword(){
        $order_source = M('OrderSource')->select();
        $this->assign('order_source',$order_source);
        if(!$_GET['create_time']){
            $_GET['create_time'] = date('Y-m-01', strtotime(date("Y-m-d")));
        } else{
            if($_GET['t'] == 1){
                $_GET['create_time'] = date('Y-m-01', strtotime('-1 month'));
                $_GET['create_time1'] = date('Y-m-t', strtotime('-1 month'));
            }
        }
        $this->assign('create_time',$_GET['create_time']);
        $this->assign('create_time1',$_GET['create_time1']);
        $this->display();
    }
/*
 * User: 沈艳艳
 * Date: 2017/08/25
 * 退费订单列表
 */
    public function return_fee(){
        $where = ' flag = 0 and status = 5 and return_fee != ""';
        $arr = D('order')->order_list($_GET,$where);
        $list = $arr['list'];
        foreach($list as $k=>$v){
            $list[$k]['name'] = M('user')->where("id = {$v['userid']}")->getField('truename');
            $list[$k]['wholeprice'] = M('trainclass')->where("type_id = {$v['school_id']} and name = '{$v['class_name']}'")->getField('wholeprice');
            if(!$list[$k]['wholeprice']){
                $list[$k]['wholeprice'] = 6500;
            }
        }
        $this->assign('count', $arr['count']);
        $this->assign('page', $arr['page']);
        $this->assign('list', $list);
        $this->assign('firstRow', $arr['firstRow']);
        $this->assign('s_nickname', $_GET['s_nickname']);
        $this->assign('truename', $_GET['truename']);
        $this->assign('ordcode', $_GET['ordcode']);
        $this->assign('pay_type', $_GET['pay_type']);
        $this->assign('customer', $_GET['customer']);
        $this->assign('trainaddress', $_GET['trainaddress']);
        $this->assign('create_time1', $_GET['create_time1']);
        $this->assign('create_time2', $_GET['create_time2']);
        $this->assign('notify_time1', $_GET['notify_time1']);
        $this->assign('notify_time2', $_GET['notify_time2']);
        $this->assign('return_fee1', $_GET['return_fee1']);
        $this->assign('return_fee2', $_GET['return_fee2']);
        $this->display();
    }
/*
 * User：沈艳艳
 * Date：2017/09/01
 * 订单列表里的flag visit 状态改变
 */
    public function flag_visit(){
        $type = I('type');
        $id = I('id');
        $info = M('order')->where(array('id'=>$id))->getField($type);
        if($info == 0){
            $_POST[$type] = 1;
        }else{
            $_POST[$type] = 0;
        }
        $res = M('order')->save($_POST);
        if($res){
            $this->success('操作成功','');
        }
    }
}
