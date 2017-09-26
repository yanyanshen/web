<?php
return array(
	//'配置项'=>'配置值'
//    'SERVER'=>'http://'.$_SERVER['HOST'],
    //数据库连接
    'SESSION_PREFIX'        =>  'xueches_', // session 前缀
    'COOKIE_PREFIX'         =>  'xueches_',      // Cookie前缀 避免冲突

    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               => '127.0.0.1', // 服务器地址
    'DB_NAME'               => 'xueches', // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'MyNewPass4!',          // 密码
//    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               => 3306, // 端口
    'DB_PREFIX'             =>  'xueches_',    // 数据库表前缀
    'DB_CHARSET'            => 'utf8', // 字符集*/
//    'DB_DSN'                =>  'sqlserver:host=SqlServer;port=3306;dbname=xueche3;charset=utf8',
    'HTTP'                  =>  'http://'.$_SERVER['HTTP_HOST'],

    'SHOW_PAGE_TRACE'       =>  true,

//支付宝配置参数
    'alipay_config'=>array(
        'partner' =>'2088111222703104',   //这里是你在成功申请支付宝接口后获取到的PID；
        'key'=>'pui5l1oeom3cost729t5fyvibx43ptap',//这里是你在成功申请支付宝接口后获取到的Key
        'sign_type'=>strtoupper('MD5'),
        'input_charset'=> strtolower('utf-8'),
        'cacert'=> getcwd().'\\cacert.pem',
        'transport'=> 'http',
    ),
    //以上配置项，是从接口包中alipay.config.php 文件中复制过来，进行配置；

    'alipay'   =>array(
    //这里是卖家的支付宝账号，也就是你申请接口时注册的支付宝账号
    'seller_email'=>'xueche517@163.com',
    //这里是异步通知页面url，提交到项目的Pay控制器的notifyurl方法；
    'notify_url'=>'http://www.517xc.cn/Pay/notifyurl',
    //这里是页面跳转通知url，提交到项目的Pay控制器的returnurl方法；
    'return_url'=>'http://www.517xc.cn/Pay/returnurl',
    //支付成功跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参payed（已支付列表）
    'successpage'=>'Pay/myorder?ordtype=payed',
    //支付失败跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参unpay（未支付列表）
    'errorpage'=>'Pay/myorder?ordtype=unpay',
        ),

    'UNIONPAY' => array(// 银联配置
        //正式环境参数
        'frontUrl' => 'https://gateway.95516.com/gateway/api/frontTransReq.do', //前台交易请求地址
        'singleQueryUrl' => 'https://gateway.95516.com/gateway/api/queryTrans.do', //单笔查询请求地址
        'signCertPath' =>getcwd().'/Public/cer/PM_898111448161069_acp.pfx', //签名证书路径
        'signCertPwd' => '000000', //签名证书密码//签名证书
        'verifyCertPath' => getcwd().'/Public/cer/verify_sign_acp.cer', //验签证书路径
        'merId' => '105550149170027', //商户代码
    ),
    'UNIONPAY_CONFIG'=>array(// 银联配置
        'version' => '5.0.0', //版本号
        'encoding' => 'GBK', //编码方式
        'signMethod' => '01', //签名方式
        'txnType' => '01', //交易类型
        'txnSubType' => '01', //交易子类
        'bizType' => '000201', //产品类型
        'channelType' => '08',//渠道类型
        'frontUrl' => "http://www.xctest.com/Home/Ypay/usernotify", //前台通知地址
        'backUrl' => "http://www.xctest.com/Home/Ypay/notify", //后台通知地址
        'frontFailUrl' => "http://www.xctest.com/Home/Ypay/unionpayfail", //失败交易前台跳转地址
        'accessType' => '0', //接入类型
        'merId' => '105550149170027', //商户代码
        'txnTime' => date('YmdHis'), //订单发送时间
        'currencyCode' => '156', //交易币种
    ),


    'config_qiniu'=>array(
        'secretKey' => 'MMXpW90zVGR8jZpN98VZKl2Tgs5E7O_yNJz2oZiE',
        'accessKey' => 'TskTfW3Reppda7c0ilwHuNwjWqMMKwXA1ful-_a_',
        'domain' => 'opewopy53.bkt.clouddn.com',//这里是查看七牛图片时的图片链接地址的域名
        'bucket' => 'uploads'//这里是七牛中的“空间”
    )

);


