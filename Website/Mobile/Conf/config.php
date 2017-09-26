<?php
return array(
	//'配置项'=>'配置值'
    'TMPL_PARSE_STRING' =>array(
        '__STATIC__'=> __ROOT__.'/Public/website/'.MODULE_NAME//前台模块的样式路径
    ),
//支付宝配置参数
    'alipay_config'=>array(
        'partner' =>'2088111222703104',   //这里是你在成功申请支付宝接口后获取到的PID；
        'seller_id'	=> '2088111222703104',
    // MD5密钥，安全检验码，由数字和字母组成的32位字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm
        'key'			=> 'pui5l1oeom3cost729t5fyvibx43ptap',

// 服务器异步通知页面路径  需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
        'notify_url' => "http://www.517xc.cn/index.php/Pay/notify_url",

// 页面跳转同步通知页面路径 需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
         'return_url' => "http://www.517xc.cn/index.php/Pay/return_url",
	     'pay_success' => "http://www.517xc.cn/index.php/Pay/pay_success",
	     'pay_fail' => "http://www.517xc.cn/index.php/Pay/pay_fail",

//签名方式
        'sign_type'    => strtoupper('MD5'),

//字符编码格式 目前支持 gbk 或 utf-8
        'input_charset'=> strtolower('utf-8'),

//ca证书路径地址，用于curl中ssl校验
//请保证cacert.pem文件在当前文件夹目录中
        'cacert'    => getcwd().'\\cacert.pem',

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        'transport'    => 'http',

// 支付类型 ，无需修改
        'payment_type' => "1",

// 产品类型，无需修改
        'service' => "create_direct_pay_by_user",
//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

//↓↓↓↓↓↓↓↓↓↓ 请在这里配置防钓鱼信息，如果没开通防钓鱼功能，为空即可 ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
// 防钓鱼时间戳  若要使用请调用类文件submit中的query_timestamp函数
       'anti_phishing_key' => "",
// 客户端的IP地址 非局域网的外网IP地址，如：221.0.0.1
        'exter_invoke_ip' => "",
    ),


);