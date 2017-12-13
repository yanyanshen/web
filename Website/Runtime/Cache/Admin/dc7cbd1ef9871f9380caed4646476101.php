<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <title>添加指导员分类</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet">
        <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
        <script src="/Public/public/js/jquery.form.js"></script>
        <script src="/Public/public/js/layer/layer.js"></script>
        <style>
            .dfinput{margin-left: 10px; border:solid 1px rgb(220,220,220);border-radius: 3px;
                width: 340px;padding: 10px 0 10px 5px}
            b{color: #FA7124}
        </style>
    </head>
    <body>
        <div class="div_head">指导员分类<?php echo ($btn); ?></div>
        <div style="margin: 10px 15px;" >
            <div style="width:30%;">
                <form action="#" method="post" id="form1" enctype="multipart/form-data">
                    <input type="hidden" name="cid" value="<?php echo ($get['id']?$get['id']:''); ?>"/>
                    <input type="hidden" value="<?php echo ($get['pid']); ?>" name="pid"/>
                    <label style="padding: 10px 10px 10px 0" >分类名称<b>*</b></label>
                    <input type="text" name="category_name" value="<?php echo ($category_name?$category_name:''); ?>" class="dfinput" placeholder="请填写分类名称" style="padding: 5px 2px"/><br>
                    <input style="margin:20px 73px;width: 137px;height: 35px;line-height: 35px;background-color: rgb(19, 181, 177);border: none;border-radius: 4px;color: #ffffff "  type="submit" id="submit" value="<?php echo ($btn?$btn:'添加'); ?>"/>
                </form>
            </div>
            <div class="div_head">教练分类列表</div>
            <div style="width:30%;margin: 20px 15px">
                <table class="table_a">
                    <tr style="background-color:  rgb(19, 181, 177);">
                            <td width="3%">序号</td>
                            <td width="10%">分类名称</td>
                            <td width="10%">添加时间</td>
                            <td width="10%">最后更新人</td>
                            <td width="10%">操作</td>
                        </tr>
                    <?php if(is_array($category)): $k = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$data): $mod = ($k % 2 );++$k;?><tr>
                            <td><?php echo ($k); ?></td>
                            <td><?php echo ($data['category_name']); ?></td>
                            <td><?php echo date('Y-m-d',$data['time']);?></td>
                            <td><?php echo ($data['update_people']); ?></td>
                            <td>
                                <a class="tablelink"  href="<?php echo U('Admin/Guider/category_index',array('id'=>$data['id'],'pid'=>$get['pid']));?>">编辑</a>
                                <a class="tablelink" href="javascript:void(0);"
                                   onclick="del_category(<?php echo ($data['id']); ?>,<?php echo ($get['pid']); ?>,'zd')">删除</a>
                            </td>
                            <script>
                                function del_category(id,pid,type){
                                    layer.msg('确定要删除吗？', {
                                        time: 0, //不自动关闭
                                        btn: ["确定", '取消'],
                                        yes: function(){
                                            location.href='<?php echo U("Admin/Coach/del_category");?>?id='+id+'&pid='+pid+
                                            '&type='+type; //此处只是为了演示，实际使用可以剔除
                                        }
                                    });
                                }
                            </script>
                        </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
                </table>
            </div>
        </div>
    </body>
</html>
<script>
    $("#submit").click(function(){
        $(this).attr('disabled',true);
        $.post('<?php echo U("Admin/Guider/category_index");?>',$('#form1').serialize(),function(res){
            if(res.status){
                layer.msg(res.info,{icon:6,time:2000},function(){
                    location.href=res.url;
                });
            }else{
                layer.msg(res.info,{icon:5,time:2000},function(){
                    location.href=res.url;
                });
            }
        },'json');
        return false;
    })
</script>