<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>我要去学车</title>
</head>
<body>
<div style="border:1px solid red;text-align: center">
    <div style="margin-left: 10px;color:#556B2F;font-size:30px;font-weight: bolder;">我要去学车</div><br/>
    <!--<img alt="模式二扫码支付" src="http://paysdk.weixin.qq.com/example/qrcode.php?data=<?php echo urlencode($url2);?>" style="width:150px;height:150px;"/>-->
    <img alt="模式二扫码支付" src="http://www.517xc.cn/index.php/Wxpay/qrcode?url=<?php echo ($url2); ?>" style="width:150px;height:150px;"/>
</div>
</body>
</html>