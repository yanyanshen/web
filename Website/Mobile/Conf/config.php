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
        'merchant_private_key' => "MIIEpAIBAAKCAQEA5Yu9GZFNsdlIgqe8rhIYD0x4ZC3WcHnldNOxarzsoylw4Exggz0thCzS9UAlfxD2TxExkogpJMFDjP4d6ffc7h07G+QL60uGQYE08A1vJ6a75hYvU3IqEbXTPTxkvtpt3+kS9lh/wb0tVnzDqdcdpxu0z53XzBi1Nufa92ijt9F0U+2ARleH7AhnFIoiQnHMe4Dmc+XPvhglv9RjLgakwSPqAIk3c4fccd9PNm9x59geB2y1yYxPty26YKpqeYERKwZd9rppJMrSgZWStyKenzcSLiIVosgFZL8AAaG0A2ptotU6KKETlbBWfuaJt/2XdldkCaUijX3UMIhQdyPJSwIDAQABAoIBACpCFHj9gAEq0CeFe73MBPPkDxHaQm0Ic86THklZKHNNMMOKLAZdH+ECY3/U5FJFLCMYNjkUqgZjMe1l5tno0JphdT1IOU2C5N9wSu+aeYkiL9tG4EWLceU6xP2z/ZQJIEslXGFPn41qJ0uRwm+k84eNGTdThqPDNLE789qyP9mZ82HJh7st93cO8O3MZ7Yl/4gk/KDfN7wXLzugVI5e5IoBsqBPfRiuQasysjD9UktsQBlsK/OU66Imk77k0NC6seoNyLiardKIC1KJ4bJLNa3u9Qo4HCzm5wGyLJ0rhUeSVlztHbMUPnH90Y8vWWdosuZFmrTvmMTPQQzBccqKV9ECgYEA/z7rSZpYdftpgwqVkcu6KVkNQk+F2yx5Hl6+w1qVyx/FRDDYp03EMN/KkKXKJ5FkYqiuGepH3YBhiXM67kvZ3kMrDcEYRE8T44Id9Vhtwf+uq4D+jL0iqBaQlmUoHh/HyaP6PjNauSBOYWtWfnSjf/iLymZqJt5FeEPZ5qH/QqkCgYEA5jlg/DM6RuaIht/Z1usVz7CwWhJXqtQOx36hN1/FEV+Lkyj+2a/YoGZtUq0WslsQ7Y79TSLJex/QSdlfR8dOUpGhqu5fnXpqJbUy0dbeR9uhi6KRoO/vaytmh1S2Ih6hbrtUCwpNrw0hjDx5Q5/RzKebKLOrEKO9kjjjJpeAGNMCgYEAtLeWnTEziq0rwkT/Kw/kSZwsYBOvwUNWqeMJC4WaYwumfqZa7vGHg9cfM5S+cY9mVNf7FIwkv7ZC2K+GPOvlYJGL7RwXE14txbn9fhVS+LUPtYwKLhlHbV00l9cdNV7o9GIuLlXr2QD/ncgCoFvy2wtd5jrm04gyBXl80OdHtKkCgYEAthcuAWuXLVrLIzpMNvOLNdD/Os6FLmU5J0qdwolp+frDD2r+Xzj5MqywzRKAACOM+Qf+ipL4Hv0jpjVaahBWf3IWF3cggxK+gAKYJmY3O0iYtjOn0U3U5MPX/TPgNo5ZipZ5u52zob/WB/AQzY7Lxn3Od9vbcna/yrZZ2z06oOcCgYA3u7qUHECj9Fhz0F6xoMXv2vPbKdZd0+FwS68IluGco0soTLQPdSJmE0M8kjPprIegoEgx0fXHDgtHJQnKiAUXs9ZB0779WC8rz6bPWuZK1uSLyk4D7jUo5/j+dA2n9SsxaT0qK1DLopKNvJ5X7XmMC7064ggANFljbYEavCMnoA==",


//        //异步通知地址
        'notify_url' => "http://www.517xc.cn/index.php/Mobile/WayPay/notify_url",

//        //同步跳转
        'return_url' => "http://www.517xc.cn/index.php/WayPay/return_url",

        //编码格式
        'charset' => "UTF-8",

        //签名方式
        'sign_type'=>"RSA2",

        //支付宝网关
        'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

        //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
        'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAhYfr6vdpMewx9HO5sJP3LXGIzwuN954AW5v38R5Jh7cLZ4zfSOSlvKElBjGhIJrKiLvT1iqFUeTq0fYw06isafsdSpMsM6zjWgvBHHVKlq6MecLFgahAzZMK1NIKWjbKdVsZESrFeo7ey2T8MvfHPL8D7SgdOKbG1LBpzONcwPGkW744osMEP0ZzsbIAbWrqc3beMkvQ/DvN8rVglYt40evv+Vz8PIy8/lWvpqfrKvf6m5QMRXRLVZKQKewwadjY1tDQHGwo4Ms2ZaJK1DfSrzvHrxTeaVDNfx4ig6zOiBtK76tou4+Cfe2SNYksEY8CYMmIJKtv5+FYlUWv4ZT33QIDAQAB",

    )



);