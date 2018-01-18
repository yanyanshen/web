<?php
return array(
	//'配置项'=>'配置值'
    'TMPL_PARSE_STRING' =>array(
        '__STATIC__'=> __ROOT__.'/Public/website/'.MODULE_NAME//前台模块的样式路径
    ),

//新版的手机网站支付宝配置参数
    'way_config' => array (
        //应用ID,您的APPID。
        'app_id' => "2017112800228343",

        //商户私钥，您的原始格式RSA私钥
        'merchant_private_key' => "?"
//        //异步通知地址
        'notify_url' => "?",

//        //同步跳转
        'return_url' => "?",

        //编码格式
        'charset' => "UTF-8",

        //签名方式
        'sign_type'=>"RSA2",

        //支付宝网关
        'gatewayUrl' => "?",

        //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
        'alipay_public_key' => "?"
    ),
// 开启路由
    'URL_ROUTER_ON'   => true,
    'URL_ROUTER_ON '=>true,
    'URL_ROUTE_RULES'=>array(
        "/^[^A-Z]+(jiaxiao\/list)$/"        => 'List/pull',//列表页
        ":name\w/jiaxiao/list/:pinyin"        => 'Detail/index',//详情页
        ':name\w/jiaxiao/list/:r$'          =>  'List/pull/r/1',//推荐筛选
        ':name\w/jiaxiao/list/:all$'          =>  'List/pull/all/1',//推荐
        ":name\w/jiaxiao/list/:pinyin\w#detail"        => 'Detail/index',//详情页
    ),
);
