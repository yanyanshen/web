<?php
namespace Mobile\Controller;
use Think\Controller;
class WxpayController extends Controller {
	/** 链接wechat接口 */
    public function _initialize(){
        vendor('Weixinpay.WxPay#Api');
        vendor('Weixinpay.WxPay#NativePay');
        vendor('Weixinpay.log');
    }

    public function index($data){

        //模式一
        /**
         * 流程：
         * 1、组装包含支付信息的url，生成二维码
         * 2、用户扫描二维码，进行支付
         * 3、确定支付之后，微信服务器会回调预先配置的回调地址，在【微信开放平台-微信支付-支付配置】中进行配置
         * 4、在接到回调通知之后，用户进行统一下单支付，并返回支付信息以完成支付（见：native_notify.php）
         * 5、支付完成之后，微信服务器会通知支付成功
         * 6、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
         */
        $notify = new \NativePay();
        $url1 = $notify->GetPrePayUrl("123456789");

//模式二
        /**
         * 流程：
         * 1、调用统一下单，取得code_url，生成二维码
         * 2、用户扫描二维码，进行支付
         * 3、支付完成之后，微信服务器会通知支付成功
         * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
         */
        $input = new \WxPayUnifiedOrder();
        $input->SetBody("我要去学车");
        $input->SetAttach("我要去学车");
//        $input->SetOut_trade_no(\WxPayConfig::MCHID.date("YmdHis"));
        $input->SetOut_trade_no($data['ordcode']);
        $input->SetTotal_fee(intval($data['price']));
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("我要去学车");
//        $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
        $input->SetNotify_url("http://www.517xc.cn/Wxpay/notify");
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id("123456789");
        $result = $notify->GetPayUrl($input);
        $url2 = $result["code_url"];
        $this->assign('url2',$url2);
        $this->display('index');
    }

//生成二维码
    public function qrcode($size=4){
        $url = urldecode($_GET['url']);
        Vendor('Phpqrcode.phpqrcode');
        \QRcode::png($url,false,QR_ECLEVEL_L,$size,2,false,0xFFFFFF,0x000000);
    }

	/* 支付回调地址 只要有数据回来  那说明   肯定是支付成功的   不支付成功不会回调*/
	public function notify(){
		$xml = $GLOBALS["HTTP_RAW_POST_DATA"];
		/* 如果不回复这个xml  微信会给我们发送三次xml */
		$su = '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
		echo $su;
    }

//    public function notify(){
//
//        // 导入微信支付sdk
//        Vendor('Weixinpay.Weixinpay');
//        $wxpay=new \Weixinpay();
//        $result=$wxpay->notify();
//        // 下面的file_put_contents是用来简单查看异步发过来的数据 测试完可以删除；
//        file_put_contents('./notify.text', json_encode($result));
//        if ($result) {
//            // 验证成功 修改数据库的订单状态等 $result['out_trade_no']为订单id
//            $where['order_sn']=$result['out_trade_no'];
//            $data['order_status']=99;
//            M('Orders')->where($where)->save($data);
//        }
//    }




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