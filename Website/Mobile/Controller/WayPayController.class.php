<?php
namespace Mobile\Controller;
use Think\Controller;
class WayPayController extends Controller{
    // 在类初始化方法中，引入相关类库
    public function _initialize(){
        header("Content-type: text/html; charset=utf-8");
        vendor('wap.wappay.buildermodel.AlipayTradeWapPayContentBuilder');
        vendor('wap.wappay.service.AlipayTradeService');
        vendor('wap.aop.request.AlipayTradeWapPayRequest');
        vendor('wap.aop.AopClient');
//        vendor('wap.aop.AopEncrypt');
    }
     public function _empty($name){
            //把所有城市的操作解析到city方法
            echo "页面有误";
        }


    /*  支付类型判断  */
    public function pay_money(){
        if (!empty($_POST['WIDout_trade_no']) && trim($_POST['WIDout_trade_no']) != "") {
            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no = $_POST['WIDout_trade_no'];

            //订单名称，必填
//            $subject = $_POST['WIDsubject'];
            $subject = '517驾校';

            //付款金额，必填
//            $total_amount = $_POST['WIDtotal_amount'];
            $total_amount = 0.01;

            //商品描述，可空
            $body = $_POST['WIDbody'];

            //超时时间
            $timeout_express = "1m";
            $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
            $payRequestBuilder->setBody($body);
            $payRequestBuilder->setSubject($subject);
            $payRequestBuilder->setOutTradeNo($out_trade_no);
            $payRequestBuilder->setTotalAmount($total_amount);
            $payRequestBuilder->setTimeExpress($timeout_express);
            $config = C('way_config');

            $payResponse = new \AlipayTradeService($config);
            $result = $payResponse->wapPay($payRequestBuilder, $config['return_url'], $config['notify_url']);
            return  $result;
        }
    }

    public function return_url(){
        $config = C('way_config');

        $arr=$_GET;

        $alipaySevice = new \AlipayTradeService($config);
        $result = $alipaySevice->check($arr);
        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if($result) {//验证成功
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
            // 获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
            $parameter = array(
                "out_trade_no" => $_GET['out_trade_no'], // 商户订单编号；
                "trade_no" => $_GET['trade_no'], // 支付宝交易号；
                "total_fee" => $_GET['total_amount'], // 实收金额；
            ); // 买家支付宝帐号；
            //商户订单号
            $out_trade_no = htmlspecialchars($_GET['out_trade_no']);
            //支付宝交易号
            $trade_no = htmlspecialchars($_GET['trade_no']);
            $where['out_trade_no'] = $out_trade_no;
            $where['trade_no'] = $trade_no;
            if (!checkorderstatus($where)) {
                orderhandle($parameter); // 进行订单处理，并传送从支付宝返回的参数；
            }
            $this->redirect('Mobile/WayPay/pay_success',array('ordcode'=>$_GET['out_trade_no'])); // 跳转到配置项中配置的支付成功页面；
            echo "验证成功<br />";
        }
        else {
            //验证失败
            echo "验证失败";
        }
    }
    function notify_url(){
        $config = C('way_config');
        $arr=$_POST;
        $alipaySevice = new \AlipayTradeService($config);
        $alipaySevice->writeLog(var_export($_POST,true));
        $result = $alipaySevice->check($arr);

        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if($result) {//验证成功
            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
            $parameter = array(
                "out_trade_no" => $_POST['out_trade_no'], // 商户订单编号；
                "trade_no" => $_POST['trade_no'], // 支付宝交易号；
                "total_fee" => $_POST['receipt_amount'], // 实收金额；
                "trade_status" =>  $_POST['trade_status'], // 交易状态
                "notify_id" => $_POST['notify_id'], // 通知校验ID。
                "notify_time" => $_POST['gmt_payment'], // 通交易付款时间。
                "buyer_email" => $_POST['buyer_logon_id']
            ); // 买家支付宝帐号；

            if($_POST['trade_status'] == 'TRADE_FINISHED') {

                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
            }
            else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序
                //注意：
                //付款完成后，支付宝系统发送该交易状态通知
                $where['out_trade_no'] = $_POST['out_trade_no'];
                if (! checkorderstatus($where)) {
                    orderhandle($parameter);
                    // 进行订单处理，并传送从支付宝返回的参数；
                }
            }
            echo "success";		//请不要修改或删除
        }else {
            //验证失败
            echo "fail";	//请不要修改或删除
        }
    }


    public function pay_fail(){
        echo '支付失败';
    }
    public function pay_success(){
        $ordcode = I('ordcode');
        $info = M('order')->field('trade_no,create_time,total_fee')->where(array('ordcode'=>$ordcode))->find();
        $log['uid'] = session('mid');
        $log['done'] = '用户手机端订单支付';
        $log['url'] = 'http://'.$_SERVER['HTTP_HOST'].'/Mobile/WayPay/pay_money';
        D('UserLog')->add_user_log($log);
        $this->assign('info',$info);
        $this->display();
    }

/*----------------------------------------------2017-10-19调用查询支付账单接口---------------------------------------*/
    public function trade_query(){
        $alipay_config = C('alipay_config');
//请求参数
        //支付宝交易号
//        $trade_no = $_POST['WIDtrade_no'];
        $trade_no ='201708108d11dfabb57aa5';
        //支付宝交易号与商户网站订单号不能同时为空         //商户订单号
        $out_trade_no = $_POST['WIDout_trade_no'];

        //构造参数
        //构造要请求的参数数组，无需改动
        $parameter = array(
            "service" => "single_trade_query",
            "partner" => trim($alipay_config['partner']),
            "trade_no"	=> $trade_no,
            "out_trade_no"	=> $out_trade_no,
            "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
        );

//建立请求
        $alipaySubmit = new \AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestHttp($parameter);
    }
/*----------------------------------------------2017-10-19调用查询支付账单接口---------------------------------------*/


}
