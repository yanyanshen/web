<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Controller\CommonController;
use Think\Page;
class OrderController extends CommonController {
/*
 * User: 沈艳艳
 * Date: 217/08/25
 * 订单列表
*/
   public function order_list(){
       //用户在网站上下单 并未付款 订单状态是未支付 未处理状态  系统自动 分配给  在线的 客服
       //1.先查询未支付未处理订单
       $permissions = M('Admin')->field('permissions,allocation')->where(array('id'=>session('admin_id')))->find();
       if($permissions['permissions'] != 1 and $permissions['allocation'] == 1){
           $order = M('Order')->field('id,status,order_status,customer')->where(array("status"=>array('in',"1,2"),'order_status'=>1,'customer'=>''))->select();
           if(!empty($order)){
               //2.查询在线的客服
               $admin = M('Admin')->where(array('permissions'=>2,'online'=>1))->select();
               $count = count($admin);
               //3.分配订单
               if($count){
                   //4.设置订单分配的时间为每天早上的9点以后
                   if(time() > strtotime(date('Y-m-d 9:10:00')) && time() < strtotime(date('Y-m-d 22:00:00'))){
                       foreach($order as $k => $v){
                           $k = $v['id']%$count;
                           M('Order')->where(array('id'=>$v['id']))->save(array('customer'=>$admin[$k]['username']));
                       }
                   }
               }
           }
       }

       session('admin_return',U('Admin/Order/order_list',array('pid'=>I('pid'),'p'=>I('p'))));
//判断是否有新建订单权限
       $pid = I('pid');
       $add_order = D('AuthRule')->getRule($pid,'新建订单');
       $this->assign('add_order',$add_order['name']);
//判断是否有订单列表处理按钮权限
       $list_info = D('AuthRule')->getRule($pid,'订单处理');
       $this->assign('list_info',$list_info['name']);
       $arr= D('order')->order_list($_GET);

       $citys=D('citys')->city_one("flag=1","id,cityname",1);
       $this->assign('citys', $citys);

//支付宝已支付未处理、待回访、待结算待回访 数量
       $count = D('Order')->order_count();
       $this->assign('count',$count);
       $this->assign('arr', $arr);
       $this->assign('get',$_GET);
       $this->assign('url',U('Admin/Order/order_list',array('pid'=>I('pid'),'p'=>I('p'))));
       //订单批量取消
       $reason = M('OrderCancelReason')->select();
       $this->assign('reason',$reason);
       $customer = M('Admin')->where(array('permissions'=>array('neq',1),'allocation'=>1))->select();
       $this->assign('customer',$customer);
       $this->display();
   }
/*
 * User: 沈艳艳
 * Date: 2017/08/25
 * 已支付未处理订单
*/
    public function pay_list(){
        session('admin_return',U('Admin/Order/pay_list',array('pid'=>I('pid'),'p'=>I('p'))));
        $_GET['status'] = 2;
        $_GET['order_status'] = 1;
        $arr = D('order')->order_list($_GET);
        $citys = D('citys')->city_one("flag=1","id,cityname",1);
        $this->assign('citys', $citys);
        $this->assign('arr', $arr);
        $this->assign('get',$_GET);
//支付宝已支付未处理、待回访、待结算待回访 数量
        $count = D('Order')->order_count();
        $this->assign('count',$count);
        $this->display();
    }
/*-------------------------2017-12-21shenyanyan-----------------------*/
//订单搜索
    public function order_search(){
        session('admin_return',U('Admin/Order/order_search'));
        if(I('tel')){
            $where = " ou.tel like '%".urldecode(I('tel'))."%'";
            $count = M('Order')->alias('o')->join('xueches_trainclass c ON c.id=o.class_name')
                ->join('xueches_trainaddress ta ON ta.id=o.trainaddress')
                ->join('xueches_order_user ou ON ou.oid=o.id')
                ->where($where)->count();
            $page = new Page($count,10);
            $list = M('Order')->alias('o')->join('xueches_trainclass c ON c.id=o.class_name')
                ->join('xueches_trainaddress ta ON ta.id=o.trainaddress')->where($where)
                ->field('o.*,ou.name,ou.tel,c.name as class_name,c.wholeprice,c.advanceprice,c.officeprice,ta.trname')
                ->join('xueches_order_user ou ON ou.oid=o.id')->select();
            $this->assign('count',$count);
            $this->assign('page',$page->show());
            $this->assign('list',$list);
        }
        $this->assign('get',$_GET);
        $this->display();
    }
/*
 * User: 沈艳艳
 * : 2017/08/25
 * 新建订单
 */
    public function add_order(){
        if(!empty($_POST)){
            $message = D('Order')->add_order($_POST);
            $this->redirect("order_list",array('pid'=>I('pid'),'p'=>I('p')),0.1,$message);
        }else{
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
            $this->assign('citys',$citys);

            $county=D('countys')->Countys_list("cityid=$cityid","id,countyname",1);
            $this->assign("countys",$county);

            $order_source = M('OrderSource')->select();
            $this->assign('order_source',$order_source);
            $this->assign('get',$_GET);
            $this->assign('url',session('admin_return'));
            $this->display();
        }
    }
/*
 * User: 沈艳艳
 * : 217/08/25
 * 订单详情
 */
    public function list_info($id){
//日志操作查看权限
        $pid = I('pid');
        $order_log = D('AuthRule')->getRule($pid,'日志操作');
        $this->assign('order_log',$order_log['name']);
//修改学员信息权限
        $stu_update = D('AuthRule')->getRule($pid,'修改学员信息');
        $this->assign('stu_update',$stu_update['name']);

//确认课程修改权限
        $class_update = D('AuthRule')->getRule($pid,'确认课程修改');
        $_GET['class_update'] = $class_update['name'];
//修改客服权限
        $customer_update = D('AuthRule')->getRule($pid,'转客服');
        $_GET['customer_update'] = $customer_update['name'];
//订单详情
        $list = M('order')->field('*')->where("id=$id")->find();
//订单来源
        $list['order_source'] = M('OrderSource')->where(array('id'=>$list['order_source']))->find();
        $list['order_keyword'] = M('OrderKeyword')->where(array('id'=>$list['order_keyword']))->getField('name');
//课程信息
        $class = M('trainclass')->field('wholeprice,name,officeprice,advanceprice,(wholeprice-advanceprice) as whole1')
            ->where(array('id'=>$list['class_name']))->find();
        $this->assign('class',$class);
//基地名称
        $list['trainaddress'] = M('trainaddress')->where(array('id'=>$list['trainaddress']))->getField('trname');
        $this->assign("list",$list);

//学员姓名电话
        $stu = M('OrderUser')->field('id,name,tel,sex')->where("oid = $id")->select();
        $this->assign('stu',$stu);
//跟单记录
        $jilu = M('customer')->where("ordcode='{$list['ordcode']}'")->order('create_time asc')->select();
//跟单客服
        $customer = M('Admin')->where(array('permissions'=>array('neq',1),'allocation'=>1))->select();
        $this->assign('customer',$customer);

        //订单取消原因
        $order_cancel = M('OrderCancelReason')->select();
        $this->assign('order_cancel',$order_cancel);


        $this->assign("jilu",$jilu);
        $this->assign("get",$_GET);
        $this->assign("url",session('admin_return'));
        $this->display();
    }
/*
 * User: 沈艳艳
 * Date: 2017/8/21
 * Time: 13:17
 * 订单详情的订单日志查看
 */
    public function order_log(){
        $order_log = D('AdminLog')->order_log(I('oid'));
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
        if($_POST){
            if(!$_POST['s_nickname']||!$_POST['class_name']||!$_POST['trainaddress']){
                $this->redirect('Admin/Order/list_info',array('id'=>$_POST['id'],'pid'=>$_POST['pid'],'p'=>$_POST['p']),0.1,'<script>alert("驾校、课程或基地不能为空")</script>');
            }else{
                $res = D('Order')->update_class($_POST);
                if($res){
                    $this->redirect('Admin/Order/list_info',array('id'=>$_POST['id'],'pid'=>$_POST['pid'],'p'=>$_POST['p']),0.1,'<script>alert("修改成功")</script>');
                }else{
                    $this->redirect('Admin/Order/list_info',array('id'=>$_POST['id'],'pid'=>$_POST['pid'],'p'=>$_POST['p']),0.1,'<script>alert("修改错误")</script>');
                }
            }
        }
    }
//跟单客服修改
    public function update_customer(){
        $_POST['lastupdate'] = session('admin_name');
        //原有客服信息
        $order = M('Order')->where(array('id'=>$_POST['id']))->find();
        $res =  M('Order')->save($_POST);
        if($res){
            $log = "客服信息:{$order['customer']} => ". I('customer');
            D('AdminLog')->addOrderLog($log,I('id'));
            $this->redirect('list_info',array('id'=>I('id'),'pid'=>I('pid'),'p'=>I('p')));
        }else{
            echo 'false';
        }
    }
/*
 * User: 沈艳艳
 * Date: 2017/08/25
 * 订单详情支付
 */
    public function queren(){
        if($_POST['t'] == 1){
            $_POST['order_status'] = 3;//进入待结算订单
            $_POST['status'] = 2;
            $_POST['lastupdate'] = session("admin_name");
            $_POST['notify_time'] = date('Y-m-d H:i:s',time());
            $res = M('Order')->save($_POST);
            $info = M('Order')->field('total_fee')->where(array('id'=>$_POST['id']))->find();
            $log = "确认收款{$info['total_fee']}元";
        }else{
            $log = D('Order')->pay_type($_POST);
            $res = $log;
        }
        if($res){
            D('AdminLog')->addOrderLog($log,I('id'));
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
            //原有的学员信息
            $order = M('Order')->where(array('id'=>I('oid')))->find();
            $user = M('OrderUser')->where(array('oid'=>I('oid')))->select();
            if($user){
                foreach($user as $v){
                    $log .= "{$v['name']}({$v['tel']}) | ";
                }
                //保存原有的学员信息 并添加日志
                $tel = I('post.tel');
                $id = I('post.id');
                if($tel){
                    foreach(I('post.name') as $k=>$v){
                        $OrderUser['name'] = $v;
                        $OrderUser['tel'] = $tel[$k];
                        $OrderUser['sex'] = I('sex')[$k];
                        if(!M('OrderUser')->where($OrderUser)->getField('id')){
                            M('OrderUser')->where(array('id'=>$id[$k]))->save($OrderUser);
                        }
                        $log1 .= " $v($tel[$k]) | ";//修改后的学员信息
                    }
                }
            }

            //添加新学员时添加日志
            $phone = I('post.phone');
            $sex1 = I('post.sex1');
            if(!empty($phone)){
                $userInfo = M('trainclass')->field('wholeprice')->where(array('oid'=>$order['class_name']))->find();
                foreach(I('post.username') as $k1=>$v1){
                    $data['oid'] = I('oid');
                    $data['name']= $v1;
                    $data['tel'] = $phone[$k1];
                    $data['sex'] = $sex1[$k1];
                    $data['price'] = $userInfo['wholeprice'];
                     M('OrderUser')->add($data);
                    $log1 .= "$v1($phone[$k1]) | ";
                }
                M('Order')->where(array('id'=>I('oid')))->setInc('num',count($phone));
                M('Order')->where(array('id'=>I('oid')))->setInc('price',count($phone)*$userInfo['wholeprice']);
            }
            //保存地址 或 备注
            if(I('address')||I('inform')){
                if(M('Order')->where(array('id'=>I('oid')))->save(array('address'=>I('address'),'inform'=>I('inform')))){
                    $log2 = "学员地址|备注:{$order['address']} | {$order['inform']}=>{$_POST['address']}|{$_POST['inform']}";
                };
            }

            $log = "学员信息:$log => $log1";

            if($log||$log2){
                $res = D('AdminLog')->addOrderLog($log,I('oid'));
                $res1 = D('AdminLog')->addOrderLog($log2,I('oid'));
                if($res || $res1){
                    $this->success('更新成功',U('Admin/Order/list_info',array('id'=>I('oid'),'pid'=>I('pid'),'p'=>I('p'))));
                }else{
                    $this->error('更新失败');
                }
            }
        }else{
            $order_user = M('OrderUser')->where("oid=".I('oid'))->select();
            $info = M('Order')->field('address,inform')->where(array('id'=>I('oid')))->find();
            $this->assign('order_user',$order_user);
            $this->assign('get',$_GET);
            $this->assign('info',$info);
            $this->display();
        }
    }
/*
 * User: 沈艳艳
 * Date: 2017/08/25
 * 订单列表到处excel表
 * @$flag  string 条件
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
        $this->redirect("list_info",array('id'=>I('id'),'pid'=>I('pid'),'p'=>I('p')),0.1,$message);
    }
/*
 * User: 沈艳艳
 * Date: 20174/08/25
 * @param string $id 订单id
 * 订单详情删除学员
 */
    public function del($oid,$id){
        //原有学员信息
        $user= M('OrderUser')->where("oid = $oid")->select();
        foreach($user as $v){
            $log .= "{$v['name']}({$v['tel']}) | ";
        }
        $res = M('OrderUser')->where("id = $id")->delete();
        if($res){
            $count = M('OrderUser')->where(array('oid'=>$oid))->count();
            if(!$count){
                M('Order')->where(array('id'=>$oid))->delete();
            }else{
                M('Order')->where(array('id'=>$oid))->setDec('num',1);
                $price = M('OrderUser')->field('price')->where(array('oid'=>$oid))->sum('price');
                M('Order')->where(array('id'=>$oid))->save(array('price'=>$price));
            }
            //删除后的学员信息
            $delete_after= M('OrderUser')->where("oid = $oid")->select();
            foreach($delete_after as $v1){
                $log1 .= "{$v1['name']}({$v1['tel']}) | ";
            }
            $log = "学员信息:$log => $log1";
            D('AdminLog')->addOrderLog($log,$oid);
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
/*
 * User: 沈艳艳
 * Date: 2017/08/24
 * 订单统计
 */
    public function order_statistics(){
        $city = D('citys')->city_one('flag = 1','cityname,id',1);
        $this->assign('city',$city);

        if(!$_GET['create_time']){
            $_GET['create_time'] = date('Y-m-01 H:i:s',strtotime('-2 month'));
            $_GET['create_time1'] = date('Y-m-t  H:i:s',time());
        }
        $order_statistics = D('Order')->order_statistics($_GET);
        $this->assign('order_statistics',$order_statistics);
        $this->assign('get',$_GET);
        $this->display();
    }
/*
* User: 沈艳艳
* Date: 2017/08/23
* 订单来源报表展示
*/
    public function order_source(){
        if(!$_GET['create_time']){
            $_GET['create_time'] = date('Y-m-01 H:i:s');
        } else{
            if($_GET['t'] == 1){
                $_GET['create_time'] = date('Y-m-01 H:i:s', strtotime('-1 month'));
                $_GET['create_time1'] = date('Y-m-t H:i:s', strtotime('-1 month'));
            }
        }
        $this->assign('get',$_GET);
        $order_source = D('Order')->order_source($_GET);
        $this->assign('order_source',$order_source);
        $this->assign('empty',"<h1>暂无数据</h1>");

        foreach($order_source as $v){
            $data['order_num'] =  $data['order_num'] + $v['order_num'];//总单数
            $data['completed_num'] = $data['completed_num'] + $v['completed_num'];//已付款未结算

            $data['end_num'] = $data['end_num'] + $v['end_num'];//结算订单数

            $data['cancel_num'] = $data['cancel_num'] + $v['cancel_num'];//取消量
        }
        //成单率
        if($data['completed_num']){
            $data['completed_lv'] = $data['completed_num'].'/'. $data['order_num'].' = '.sprintf('%.2f',$data['completed_num']/$data['order_num']*100).'%';
        }
        //结算率
        if($data['end_num']){
            $data['end_lv'] = $data['end_num'].'/'.$data['order_num'].' = '.sprintf('%.2f',$data['end_num']/$data['order_num']*100).'%';
        }

        //取消率
        if($data['cancel_num']){
            $data['cancel_lv'] = $data['cancel_num'].'/'.$data['order_num'].' = '.sprintf('%.2f',$data['cancel_num']/$data['order_num']*100).'%';
        }
        $this->assign('data',$data);
        $this->display();
    }
/*
 * User: 沈艳艳
 * Date: 207/08/24
 * 订单关键词来源统计
*/
    public function order_keyword(){
        if(!$_GET['create_time']){
            $_GET['create_time'] = date('Y-m-01 H:i:s');
        } else{
            if($_GET['t'] == 1){
                $_GET['create_time'] = date('Y-m-01 H:i:s', strtotime('-1 month'));
                $_GET['create_time1'] = date('Y-m-t H:i:s', strtotime('-1 month'));
            }
        }

        $order_source = D('Order')->order_keyword($_GET);
        $this->assign('order_source',$order_source);

        foreach($order_source as $v){
            $data['order_num'] = $data['order_num']  + $v['order_num'];//订单总数
            $data['completed_num'] = $data['completed_num'] + $v['completed_num'];//已付款未结算
            $data['end_num'] = $data['end_num'] + $v['end_num'];//已结算订单量
            $data['cancel_num'] = $data['cancel_num'] + $v['cancel_num'];//取消总数
        }
        //成单率
        if( $data['completed_num']){
            $data['completed_lv'] =  $data['completed_num'].'/'.$data['order_num'].' = '.sprintf('%.2f', $data['completed_num']/$data['order_num']*100).'%';
        }
        //结算率
        if($data['end_num']){
            $data['end_lv'] =  $data['end_num'].'/'.$data['order_num'].' = '.sprintf('%.2f',$data['end_num']/$data['order_num']*100).'%';
        }
        //取消率
        if($data['cancel_num']){
            $data['cancel_lv'] = $data['cancel_num'].'/'.$data['order_num'].' = '.sprintf('%.2f',$data['cancel_num']/$data['order_num']*100).'%';
        }

        $this->assign('empty',"<h1>暂无数据</h1>");
        $this->assign('data',$data);
        $this->assign('get',$_GET);
        $this->display();
    }
//其他优惠更新
    public function sale_price(){
        $order = M('Order')->where(array('id'=>I('id')))->find();
        $_POST['lastupdate'] = session('admin_name');
        $res = M('Order')->save($_POST);
        if($res){
            $log = "订单其他优惠:{$order['sale_price']}=>".I('sale_price');
            D('AdminLog')->addOrderLog($log,I('id'));
            $this->redirect('list_info',array('id'=>I('id'),'pid'=>I('pid'),'p'=>I('p')),0,'修改成功');
        }else{
            echo "false";
        }
    }
//订单详情里 取消订单
    public function cancel_order(){
        $_POST['status'] = 5;
        $_POST['order_status'] = 5;
        $_POST['lastupdate'] = session('admin_name');
        $_POST['cancel_time'] = date('Y-m-d H:i:s',time());
        $new_cancel_reason = M('order_cancel_reason')->where(array('id'=>$_POST['cancel_reason']))->getField('reason');
        $log = "订单取消原因: => {$new_cancel_reason}";
        $res =  M('Order')->save($_POST);
        if($res){
            D('AdminLog')->addOrderLog($log,I('id'));
            $this->redirect('list_info',array('id'=>I('id'),'pid'=>I('pid'),'p'=>I('p')));
        }else{
            echo 'false';
        }
    }
/*---------------------2018-1-9shenyanyan------------------*/
//订单列表的批量取消订单按钮
    public function batch_operate(){
        print_r($_GET);
    }
//订单列表的批量转客服按钮
    public function transfer_customer(){
        $arrId = explode(',',I('str'));
        $_POST['lastupdate'] = session('admin_name');

        foreach($arrId as $v){
            //原来的跟单客服
            $customer = M('Order')->where(array('id'=>$v))->getField('customer');
            $_POST['id'] = $v;
            M('Order')->save($_POST);
            $log = "客服信息: $customer => {$_POST['customer']}";
            D('AdminLog')->addOrderLog($log,$v);
        }
        $this->redirect('order_list',array('pid'=>I('pid'),'p'=>I('p')));
    }
}
