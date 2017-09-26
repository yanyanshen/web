<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

    <title>订单列表</title>

    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>

    <style>
        #page a,#page span{
            display: inline-block; width:15px;height:15px ;padding: 5px;margin: 2px;text-decoration: none;
            text-align: center; line-height: 15px;background: #f0ead8; color:#000000;  border: 1px solid #c2d2d7;
        }
        #page a:hover{background:#F27602;color:#FF0000;}
        #page span{ background:#F27602; color:#FF0000; font-weight: bold;}
        #page{ float: right; }
        .tablelink{ cursor: pointer;}
        .message,.blue{font-size: 15px}
        .tr_color{background-color: #9F88FF}
    </style>
</head>
<body>
    <div class="div_head">
        <span>
            <span style="float: left;">当前位置是：订单管理-》订单列表</span>
            <span style="float: right; margin-right: 8px; font-weight: bold;">
                <a style="text-decoration: none;" href="<?php echo U('Admin/Order/add_order');?>">【添加订单】</a>
            </span>
        </span>
    </div>
    <div></div>
    <div class="div_search">
        <span style="float:left">
            <form action="<?php echo U('Admin/Order/order_list');?>" id='form' method="get">
                订单类型：<select name="order_type">
                    <option value="0" >请选择</option>
                    <option value="1" <?php echo ($order_type==1?selected:''); ?>>驾校订单</option>
                    <option value="2" <?php echo ($order_type==2?selected:''); ?>>教练订单</option>
                    <option value="3" <?php echo ($order_type==3?selected:''); ?>>指导员订单</option>
                    <option value="4" <?php echo ($order_type==4?selected:''); ?>>预约订单</option>
                </select>
                订单状态：<select name="status">
                <option value="0" >请选择</option>
                <option value="1" <?php echo ($status==1?selected:''); ?>>待付款</option>
                <option value="2" <?php echo ($status==2?selected:''); ?>>待确认</option>
                <option value="3" <?php echo ($status==3?selected:''); ?>>待评价</option>
                <option value="4" <?php echo ($status==4?selected:''); ?>>已完成</option>
                <option value="5" <?php echo ($status==5?selected:''); ?>>已取消</option>
            </select>
                订单号：<input type="text" name='trade_no' value="<?php echo ($trade_no?$trade_no:''); ?>" />
                驾校/教练/指导员：<input type="text" name='nickname' value="<?php echo ($nickname?$nickname:''); ?>" />
                手机号：<input type="text" name='tel' value="<?php echo ($tel?$tel:''); ?>"/>
                用户名：<input type="text" name='name' value="<?php echo ($name?$name:''); ?>"/>
                <input value="查询" type="submit" id='btn'/>
                <input value="清空全部" type="reset" id=''/>
            </form>
        </span>
        <span style="float:right">总计：<?php echo ($count); ?>　　</span>
    </div>
    <div style="font-size: 13px; margin: 10px 5px;">
    <table class="table_a" border="1" width="100%">
        <tbody>
            <tr style="font-weight: bold;">
                <th width="2%">编号</th>
                <th width="10%">回执订单号</th>
                <th width="4%">订单类型</th>
                <th width="4%">订单创建</th>
                <th width="8%">下单时间</th>
                <th width="4%">用户名</th>
                <th width="8%">驾校/教练/指导员</th>
                <th width="8%">课程名</th>
                <th width="4%">订单状态</th>
                <th width="5%">支付方式</th>
                <th width="5%">跟单客服</th>
                <th width="8%">回访日期</th>
                <th width="4%">最后更新人</th>
                <th width="6%">状态</th>
                <th width="5%">操作</th>
            </tr>
            <?php if(is_array($list)): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                    <td><?php echo ($k+$firstRow); ?></td>
                    <td><?php echo ($v["trade_no"]); ?></td>
                    <td>
                        <?php if($v["order_type"] == 1): ?>驾校订单
                            <?php elseif($v["order_type"] == 2): ?>
                            教练订单
                            <?php elseif($v["order_type"] == 3): ?>
                            指导员订单
                            <?php elseif($v["order_type"] == 4): ?>
                            预约订单<?php endif; ?>
                    </td>
                    <td><?php echo ($v['userid']==0?'管理员':$v['order_create']); ?></td>
                    <td><?php echo date('Y-m-d H:i:s',$v['create_time']);?></td>
                    <td><?php echo ($v["name"]); ?></td>
                    <td><?php echo ($v["nickname"]); ?></td>
                    <td><?php echo ($v["class_name"]); ?></td>
                    <td>
                        <?php if($v["status"] == 1): ?>待付款<?php endif; ?>
                        <?php if($v["status"] == 2): ?>待确认<?php endif; ?>
                        <?php if($v["status"] == 3): ?>待评价<?php endif; ?>
                        <?php if($v["status"] == 4): ?>已完成<?php endif; ?>
                        <?php if($v["status"] == 5): ?>已取消<?php endif; ?>
                    </td>
                    <td>
                        <?php if($v["pay_type"] == 1): ?>支付宝<?php endif; ?>
                    </td>
                    <td>
                        <?php if($v["lastupdate"] == '0'): ?>暂无
                            <?php else: ?>
                            <?php echo ($v["lastupdate"]); endif; ?>
                    </td>
                    <td>
                        <?php if($v["return_time"] == '0'): ?>未回访
                            <?php else: ?>
                            <?php echo date('Y-m-d H:i:s',$v.return_time); endif; ?>
                    </td>
                    <td>
                        <?php if($v["lastupdate"] == '0'): ?>暂无
                            <?php else: ?>
                            <?php echo ($v["lastupdate"]); endif; ?>
                    </td>
                    <td>
                        <?php echo ($v['flag']==0?'未处理':'已处理'); ?>
                        <a class="flag" flag_id = "<?php echo ($v['id']); ?>" href="javascript:;">
                            <?php echo ($v['flag']==0?'已处理':'未处理'); ?>
                        </a>
                    </td>
                    <td style="text-align: center">
                        <a href="<?php echo U('Admin/School/jx_editor?id='.$v['id']);?>">处理</a>　
                </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
        </tbody>
    </table>
    <div id="page" style="float: left">
        <?php echo ($page); ?>
    </div>
</div>
    <script>
        $(function(){
            $(".flag").click(function(){
                var id = $(this).attr('flag_id');
                $.post('<?php echo U("Admin/Order/change_flag");?>',{id:id},function(res){
                  if(res.status == 1){
                      location.href = '';
                  }else{
                      alert('更改失败')
                  }
                },'json')
            })
        })
    </script>
</body>
</html>