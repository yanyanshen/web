<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        if(I('city')){
            session('city',I('city'));
        }else{
            $city = getCity();
            session('city',$city);
        }
        $cityname = session('city');
        $cityid = M('citys')->where(array('cityname'=>array('like',"%$cityname%")))->getField('id');

        $this->schools_list($cityid);
        $this->coach_top($cityid);
        $this->guider_top($cityid);
        $this->schools_hot($cityid);
        $this->display();
    }


/*--------------------------2017-12-06shenyanyan---------------------------*/
//pc端首页排行榜--驾校
    public function schools_list($cityid){
        $where['s.cityid'] = $cityid;
        $where['s.recommand'] = 1;
        $where['s.type'] = 'jx';
        $where['s.show_forbid'] = 1;
        $order='s.order desc';
        $schools=D('School')->schools_list($where,$order);
        $empty='<h1 style="text-align: center;padding-top: 50px">暂时没有数据<h1>';
        $this->assign('schools',$schools);
        $this->assign('empty',$empty);
    }
//pc端首页排行榜--教练
    public function coach_top($cityid){
        $where['s.cityid'] = $cityid;
        $where['s.recommand'] = 1;
        $where['s.type'] = 'jl';
        $where['s.show_forbid'] = 1;
        $order='s.order desc';
        $coachs=D('School')->schools_list($where,$order);
        $empty='<h1 style="text-align: center;padding-top: 50px">暂时没有数据<h1>';
        $this->assign('coachs',$coachs);
        $this->assign('empty',$empty);
    }
//pc端首页排行榜--指导员
    public function guider_top($cityid){
        $where['s.cityid'] = $cityid;
        $where['s.recommand'] = 1;
        $where['s.type'] = 'zd';
        $where['s.show_forbid'] = 1;
        $order='s.order desc';
        $coachs=D('School')->schools_list($where,$order);
        $empty='<h1 style="text-align: center;padding-top: 50px">暂时没有数据<h1>';
        $this->assign('guiders',$coachs);
        $this->assign('empty',$empty);
    }
//获取首页热门驾校数据
    public function schools_hot($cityid){
        $where['s.cityid']=$cityid;
        $where['s.cityid']=$cityid;
        $where['s.hot']=1;
        $where['s.type']='jx';
        $where['s.show_forbid'] = 1;
        $order='s.order desc';
        $field = 's.nickname,s.id,s.student_num,s.minprice,s.jtype,s.highprice,s.picurl,s.picname';
        $hots=D('School')->getHotList($where,$order,$field,0,5);
        $hotsRight=D('School')->getHotList($where,$order,$field,5,4);
        $hotsRight1=D('School')->getHotList($where,$order,$field,9,4);
        $this->assign('hots',$hots);
        $this->assign('hotsRight',$hotsRight);
        $this->assign('hotsRight1',$hotsRight1);
    }



    //....测试....
    /**
     * 微信 公众号jssdk支付
     */
    public function weixinpay_js(){
        // 此处根据实际业务情况生成订单 然后拿着订单去支付

        // 用时间戳虚拟一个订单号  （请根据实际业务更改）
        $out_trade_no=time();
        // 组合url
        $url=U('Api/Weixinpay/pay',array('out_trade_no'=>$out_trade_no));
        // 前往支付
        redirect($url);
    }

    /**
     * 微信 扫描支付
     */
    public function weixinpay_qrcode(){
        // 此处根据实际业务情况生成订单 然后拿着订单去支付

        // 虚拟的订单 请根据实际业务更改
        $out_trade_no='MJ201611058904421';
        $order=array(
            'body'=>'test',
            'total_fee'=>2,
            'out_trade_no'=>$out_trade_no,
            'product_id'=>1
        );
        $order['trade_type']='NATIVE';
        Vendor('Weixinpay.Weixinpay');
        $weixinpay=new \Weixinpay();
        $weixinpay->pay($order);

    }

    public function weixinpay(){
        $this->assign('out_trade_no','MJ201611058904421');
        $this->display();
    }


    public function getOrderStatusByNo(){
        $out_trade_no=$_POST['out_trade_no'];
        $order_status=M('Orders')->where(array('order_sn'=>$out_trade_no))->getfield('order_status');
        if($order_status){
            $this->success($order_status);
        }else{
            $this->error('error');
        }
    }

    public function paySuccess(){
        $this->display();
    }

}