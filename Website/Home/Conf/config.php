<?php
return array(
	//'配置项'=>'配置值'
    'TMPL_PARSE_STRING' =>array(
        '__STATIC__'=> __ROOT__.'/Public/website/'.MODULE_NAME//前台模块的样式路径
    ),
//微信支付 配置参数
    'WEIXINPAY_CONFIG'       => array(
        'APPID'              => 'wxee302xxxxx0cb2', // 微信APPID
        'MCHID'              => '131xxxx701', // 微信支付MCHID 商户收款账号
        'KEY'                => 'jhasdhjbasxxxxxwqe465w54', // 微信支付KEY
        'APPSECRET'          => 'd7f8bf269c4xxxxx0889d18d0678',  //公众帐号secert
        'NOTIFY_URL'         => 'http://sc1212.com/Api/Weixinpay/notify/', // 接收支付状态的连接
    )
);