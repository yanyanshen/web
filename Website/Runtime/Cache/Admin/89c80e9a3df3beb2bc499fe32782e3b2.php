<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>简介图片列表</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script src="/Public/public/js/layer/layer.js"></script>
</head>
<body>
    <div class="div_head">
        <?php echo ($get['title']); ?>
        <a style="text-decoration: none;color:#fa7124;"
           href="<?php echo ($get['add_url']); ?>">【<?php echo ($get['title']); ?>添加】</a>
        <a style="text-decoration: none;color:#fa7124;"
           href="<?php echo ($url); ?>">【返回】</a>
        <a href="" style="padding: 2px 10px;text-decoration: none;color: #323232">【刷新】</a>
        <span class="span">总计：<?php echo ($count); ?></span>
    </div>
    <div style="margin: 10px 5px;">
    <table class="table_a" width="100%">
        <tbody>
            <tr style="background-color:  rgb(19, 181, 177);">
                <th width="2%">编号</th>
                <th width="2%">ID</th>
                <th width="5%">图片</th>
                <th width="10%">图片路径</th>
                <th width="4%">添加时间</th>
                <th width="4%">最后更新人</th>
                <th width="10%">操作</th>
            </tr>
            <?php if(is_array($info)): $k = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                    <td><?php echo ($k+$firstRow); ?></td>
                    <td><?php echo ($v["id"]); ?></td>
                    <td>
                        <?php if($v['type'] == 'jx'): ?><img src="<?php echo ($http); ?>/Uploads/School_logo/<?php echo ($v['picurl']); echo ($v['picname']); ?>" alt="" style="border-radius:50%" width="50" height="40" />
                            <?php elseif($v['type'] == 'jl'): ?>
                            <img src="<?php echo ($http); ?>/Uploads/Coach_logo/<?php echo ($v['picurl']); echo ($v['picname']); ?>" alt="" style="border-radius:50%" width="50" height="40" />
                            <?php elseif($v['type'] == 'zd'): ?>
                            <img src="<?php echo ($http); ?>/Uploads/guider_logo/<?php echo ($v['picurl']); echo ($v['picname']); ?>" alt="" style="border-radius:50%" width="50" height="40" /><?php endif; ?>
                    </td>
                    <td>
                        <?php if($v['type'] == 'jx'): ?>Uploads/School_logo/<?php echo ($v["picurl"]); echo ($v["picname"]); ?>
                            <?php elseif($v['type'] == 'jl'): ?>
                            Uploads/Coach_logo/<?php echo ($v["picurl"]); echo ($v["picname"]); ?>
                            <?php elseif($v['type'] == 'zd'): ?>
                            Uploads/guider_logo/<?php echo ($v["picurl"]); echo ($v["picname"]); endif; ?>
                    </td>
                    <td><?php echo date('Y-m-d H:i:s',$v['ntime']);?></td>
                    <td><?php echo ($v["lastupdate"]); ?></td>
                    <td>
                        <a class="tablelink" href="javascript:void(0);"
                           onclick="del(<?php echo ($v['id']); ?>,<?php echo ($get['pid']); ?>,'<?php echo ($v['type']); ?>',<?php echo ($get['id']); ?>,<?php echo ($get['t']); ?>,<?php echo ($get['p']?$get['p']:1); ?>)">删除</a>
                    </td>
                    <script>
                        function del(id,pid,type,type_id,t,p){
                            layer.msg('确定要删除吗？', {
                                time: 0, //不自动关闭
                                btn: ["确定", '取消'],
                                yes: function(){
                                    location.href='<?php echo U("Admin/Environment/abstract_pic_del");?>?id='+id+'&pid='+pid+
                                    '&type='+type+'&type_id='+type_id+'&t='+t+'&p='+p; //此处只是为了演示，实际使用可以剔除
                                }
                            });
                        }
                    </script>
                </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
        </tbody>
    </table>
    <div id="page">
        <?php echo ($list['page']); ?>
    </div>
</div>
</body>
</html>