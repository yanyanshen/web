<?php
return array(
    'TMPL_PARSE_STRING' =>array(
        '__STATIC__'=> __ROOT__.'/Public/website/'.MODULE_NAME//前台模块的样式路�?
    ),

/*------------------2017-10-13腾讯云COS存储文件 配置信息--------------------------*/
    'cos_domain' => array(
        'cos' => array(
            'app_id' => '?',
            'secret_id' => '?',
            'secret_key' => '?',
            'region' => 'sh',   // bucket所属地域：华北 'tj' 华东 'sh' 华南 'gz'
            'timeout' => 60
        ),
        'domain' => array(
            'domain_name' => 'www517xccnvideo'
        ),
    ),
/*------------------2017-10-13腾讯云COS存储文件 配置信息--------------------------*/

);
