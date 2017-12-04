<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function Index(){
        $this->display('index');
    }


    //获取首页驾校的数据
    public function schools_list($id){
        $where['citys_id']=$id;
        $where['schools_search']=1;
        $where['schools_order']=array('neq',0);
        $where['schools_status']=1;
        $order='schools_order';
        $schools=D('Schools')->getSchoolList($where,$order);
        $empty='<h1 style="text-align: center;padding-top: 50px">暂时没有数据<h1>';
        $this->assign('schools',$schools);
        $this->assign('empty',$empty);
    }
    //获取首页热门驾校数据
    public function schools_hot($id){
        $where['citys_id']=$id;
        $where['schools_hot']=1;
        $where['schools_status']=1;
        $where['schools_order']=array('neq',0);
        $order='schools_order';
        $type_name='C1';
        $hots=D('Schools')->getHotList($where,$order,$type_name);
        $this->assign('hots',$hots);
        $this->assign('hotsRight',$hots);
        $this->assign('hotsRight1',$hots);
    }

    //获取首页教练的数�?
    public function coachs_list($id){
        $where['citys_id']=$id;
        $where['coachs_search']=1;
        $where['coachs_status']=1;
        $where['coachs_order']=array('neq',0);
        $order='coachs_order';
        $coachs=D('Coachs')->getCoachList($where,$order);
        $this->assign('coachs',$coachs);
    }
    //获取首页指导员的数据
    public function offers_list($id){
        $where['citys_id']=$id;
        $where['offers_search']=1;
        $where['offers_status']=1;
        $where['offers_order']=array('neq',0);
        $order='offers_order';
        $offers=D('Offers')->getOfferList($where,$order);
        $this->assign('offers',$offers);
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