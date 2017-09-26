<?php
namespace Mobile\Controller;
use Think\Controller;
use Admin\Common\Controller\CommonController;
class PayController extends CommonController{
 public function _empty($name){
        //把所有城市的操作解析到city方法
        echo "页面有误";
    }
    // 在类初始化方法中，引入相关类库
    public function _initialize(){
            vendor('Alipay.Corefunction');
            vendor('Alipay.Md5function');
            vendor('Alipay.AlipayNotify');
            vendor('Alipay.AlipaySubmit');
    }

    /*
     * 该方法其实就是将接口文件包下alipayapi.php的内容复制过来
     * 然后进行相关处理
     */
    public function pay_money($data)
    {
        $out_trade_no = $data['ordcode'];

        //订单名称，必填
        $subject = '我要去学车';

        //付款金额，必填
        $total_fee = '0.01';

        //商品描述，可空
        $body = '';

        $alipay_config = C('alipay_config');



        /************************************************************/

//构造要请求的参数数组，无需改动
        $parameter = array(
            "service"       => $alipay_config['service'],
            "partner"       => $alipay_config['partner'],
            "seller_id"  => $alipay_config['seller_id'],
            "payment_type"	=> $alipay_config['payment_type'],
            "notify_url"	=> $alipay_config['notify_url'],
            "return_url"	=> $alipay_config['return_url'],

            "anti_phishing_key"=>$alipay_config['anti_phishing_key'],
            "exter_invoke_ip"=>$alipay_config['exter_invoke_ip'],
            "out_trade_no"	=> $out_trade_no,
            "subject"	=> $subject,
            "total_fee"	=> $total_fee,
            "body"	=> $body,
            "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
            //其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.kiX33I&treeId=62&articleId=103740&docType=1
            //如"参数名"=>"参数值"
        );

//建立请求
        $alipaySubmit = new \AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo $html_text;
    }

    /*
     * 服务器异步通知页面方法
     * 其实这里就是将notify_url.php文件中的代码复制过来进行处理
     */
    function notify_url(){
//计算得出通知验证结果
        $alipay_config = C('alipay_config');
        $alipayNotify = new \AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();

        if($verify_result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代


            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表


            //商户订单号

            $out_trade_no = $_POST['out_trade_no'];

            //支付宝交易号

            $trade_no = $_POST['trade_no'];

            //交易状态
            $trade_status = $_POST['trade_status'];

            $total_fee = $_POST['total_fee']; // 交易金额
            $notify_id = $_POST['notify_id']; // 通知校验ID。
            $notify_time = $_POST['notify_time']; // 通知的发送时间。格式为yyyy-MM-dd HH:mm:ss。
            $buyer_email = $_POST['buyer_email']; // 买家支付宝帐号；
            $parameter = array(
                "out_trade_no" => $out_trade_no, // 商户订单编号；
                "trade_no" => $trade_no, // 支付宝交易号；
                "total_fee" => $total_fee, // 交易金额；
                "trade_status" => $trade_status, // 交易状态
                "notify_id" => $notify_id, // 通知校验ID。
                "notify_time" => $notify_time, // 通知的发送时间。
                "buyer_email" => $buyer_email
            ); // 买家支付宝帐号；

            if($_POST['trade_status'] == 'TRADE_FINISHED') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }
            else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //付款完成后，支付宝系统发送该交易状态通知

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
                if (! checkorderstatus($out_trade_no)) {
                    orderhandle($parameter);
                    // 进行订单处理，并传送从支付宝返回的参数；
                }
            }

            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

            echo "success";		//请不要修改或删除

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else {
            //验证失败
            echo "fail";

            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }
    }

    /*
   页面跳转处理方法；
   这里其实就是将return_url.php这个文件中的代码复制过来，进行处理；
   */
    function return_url(){
        $alipay_config = C('alipay_config');
//计算得出通知验证结果
        $alipayNotify = new \AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyReturn();
        if($verify_result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代码

            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

            // 验证成功
            // 获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
            $out_trade_no = $_GET['out_trade_no']; // 商户订单号
            $trade_no = $_GET['trade_no']; // 支付宝交易号
            $trade_status = $_GET['trade_status']; // 交易状态
            $total_fee = $_GET['total_fee']; // 交易金额
            $notify_id = $_GET['notify_id']; // 通知校验ID。
            $notify_time = $_GET['notify_time']; // 通知的发送时间。
            $buyer_email = $_GET['buyer_email']; // 买家支付宝帐号；

            $parameter = array(
                "out_trade_no" => $out_trade_no, // 商户订单编号；
                "trade_no" => $trade_no, // 支付宝交易号；
                "total_fee" => $total_fee, // 交易金额；
                "trade_status" => $trade_status, // 交易状态
                "notify_id" => $notify_id, // 通知校验ID。
                "notify_time" => $notify_time, // 通知的发送时间。
                "buyer_email" => $buyer_email
            ); // 买家支付宝帐号

            if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                if (! checkorderstatus($out_trade_no)) {
                    orderhandle($parameter); // 进行订单处理，并传送从支付宝返回的参数；
                }
                $this->redirect('Mobile/Pay/pay_success',array('ordcode'=>$out_trade_no)); // 跳转到配置项中配置的支付成功页面；
            }
            echo "验证成功<br />";
        }
        else {
            //验证失败
            //如要调试，请看alipay_notify.php页面的verifyReturn函数
//            echo "验证失败";
            $this->redirect('Pay/pay_fail');
        }
//        echo '';
    }

    public function pay_fail(){
        echo '支付失败';
    }
    public function pay_success(){
        $ordcode = I('ordcode');
        $info = M('order')->field('trade_no,create_time,total_fee')->where(array('ordcode'=>$ordcode))->find();
        $this->assign('info',$info);
        $this->display();
    }

}
