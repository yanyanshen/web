<?php
return array(
	//'配置项'=>'配置值'
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

    'URL_MODEL'             => 2,//设置REWRITE模式

    'SHOW_PAGE_TRACE'       =>  false,

    //关闭数据字段缓存
    'DB_FIELD_CACHE' => false,

    'APP_SUB_DOMAIN_DEPLOY'   =>    1, // 开启子域名或者IP配置
    'APP_SUB_DOMAIN_RULES'    =>    array(
        /* 域名部署配置*/
        'm.517xc.cn'=> 'Mobile',
        'a.517xc.cn'=> 'Admin',
        /*格式2: '子域名或泛域名或IP'=> array('模块名[/控制器名]','var1=a&var2=b&var3=*');*/
    ),
//设置可访问的模块和默认的模块
    'MODULE_ALLOW_LIST' => array('Admin','Home','Mobile'),
//    'DEFAULT_MODULE' => 'Mobile',
);


