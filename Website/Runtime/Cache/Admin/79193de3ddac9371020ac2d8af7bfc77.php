<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>评论日志</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script src="/Public/public/js/layer/layer.js"></script>
    <script  src="/Public/public/js/My97DatePicker/WdatePicker.js"></script>
    <style>
        .table_a td{text-align: left}
    </style>
</head>
<body>
    <div class="div_head">
        评论列表
        <span style="margin-left: 20%;"><a href='<?php echo U("Admin/Student/evaluate_list",array("flag"=>0,"pid"=>$get["pid"]));?>' style="text-decoration: none"><?php echo ($no_reply); ?> 条未回复</a></span>
        <span class="span">总计：<?php echo ($count); ?></span>
    </div>
    <div class="div_search">
        <span>
            <form action="?" id='form1' method="get" name="form1">
                <span>
                    驾校简称：<input type="text" name='nickname' style="width: 100px"  value="<?php echo ($nickname?$nickname:''); ?>" />
                </span>
                <span>
                    评论时间：<input type="text" style="width: 100px"  onClick="WdatePicker()" value="<?php echo ($create_time1?$create_time1:''); ?>" name="create_time1"/>
                    至
                    <input type="text" style="width: 100px" value="<?php echo ($create_time2?$create_time2:''); ?>"  onClick="WdatePicker()" name="create_time2"/>
                </span>
                <span style="margin-left: 5px">
                    <input style="font-size: 11px" value="查询" type="submit" id="b"  onclick="submitYouFrom('<?php echo U("Admin/Student/evaluate_list",array('p'=>$get['p'],'pid'=>$get['pid']));?>')"/>
                    <input style="font-size: 11px" value="清空" type="reset" id="b" />
                </span>
                <script type="text/javascript" language="javascript">
                    function submitYouFrom(path){
                        $('#form1').attr('action',path);
                        $('#form1').submit();
                    }
                </script>
            </form>
        </span>
    </div>
    <div style="margin: 10px 5px;">
    <table class="table_a" width="100%">
        <tbody>
            <tr style="background-color:rgb(19, 181, 177);">
                <th width="2%">编号</th>
                <th width="2%">ID</th>
                <th width="3%">用户</th>
                <th width="5%">驾校</th>
                <th width="15%">评论内容</th>
                <th width="15%">追加内容</th>
                <th width="2%">评分</th>
                <th width="3%">lastip</th>
                <th width="3%">联系电话</th>
                <th width="3%">状态</th>
                <th width="4%">操作</th>
            </tr>
            <?php if(is_array($evaluate)): $k = 0; $__LIST__ = $evaluate;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                    <td><?php echo ($k+$firstRow); ?></td>
                    <td><?php echo ($v["id"]); ?></td>
                    <td><?php echo ($v["truename"]); ?></td>
                    <td><?php echo ($v["nickname"]); ?></td>
                    <td><span style="color: #FA7124">【<?php echo ($v['ntime']); ?>】</span><?php echo ($v["content"]); ?></td>
                    <td>
                        <?php if($v["ucontent"] == ''): ?>无
                            <?php else: ?>
                            <span style="color: #FA7124">【<?php echo ($v['untime']); ?>】</span>
                            <?php echo ($v["ucontent"]); endif; ?>
                    </td>
                    <td><?php echo ($v['score']); ?></td>
                    <td><?php echo ($v['lastip']); ?></td>
                    <td><?php echo ($v['phone']); ?></td>
                    <td>
                        <?php echo ($v['flag']==0?'未回复':'已回复'); ?>
                    </td>
                    <td>
                        <?php if($v['flag'] == 0): ?><a class="tablelink" onclick="evaluate_reply(<?php echo ($v['id']); ?>,<?php echo ($get['pid']); ?>,<?php echo ($get['p']?$get['p']:1); ?>)" href="javascript:;">回复</a>
                        <?php else: ?>
                            <a class="tablelink" onclick="evaluate_reply(<?php echo ($v['id']); ?>,<?php echo ($get['pid']); ?>,<?php echo ($get['p']?$get['p']:1); ?>)" href="javascript:;">查看</a><?php endif; ?>
                        <a class="tablelink" href="<?php echo U('Student/evaluate_del',array('id'=>$v['id'],'p'=>$get['p'],'pid'=>$get['pid']));?>" onclick="if(confirm('确认删除吗?')==false)  return false;">删除</a>
                    </td>
                </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
        </tbody>
    </table>
    <div id="page">
        <?php echo ($page); ?>
    </div>
</div>
</body>
</html>
<script>
    function evaluate_reply(id,pid,p){
        layer.open({
            type: 2,
            title:'客服回复',
            skin: 'layui-layer-rim', //加上边框
            area: ['800px', '600px'], //宽高
            content:"<?php echo U('Admin/Student/evaluate_reply');?>?id="+id+'&p='+p+'&pid='+pid
        });
    }
</script>