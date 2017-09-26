<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>菜单列表</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script  src="/Public/public/js/layer/layer.js"></script>
    <style>
        #page a,#page span{display: inline-block; width:15px;height:15px ;padding: 5px;margin: 2px;text-decoration: none;
            text-align: center; line-height: 15px;background: #f0ead8; color:#000000;  border: 1px solid #c2d2d7; }
        #page a:hover{background:#F27602;color:#FF0000;}
        #page span{ background:#F27602; color:#FF0000; font-weight: bold;}
        .table_a td,th{border:1px solid rgba(39, 164, 237, 0.22);font-size: 13px;}
        .table_a  td{  border: dotted 1px rgba(39, 164, 237, 0.22);}
    </style>
</head>
<body>
    <div class="div_head" style="background-color: rgb(129, 191, 249);">
        <span>
            <span style="float: left;font-weight: bolder;color: #ffffff">菜单列表</span>
            <span style=" margin-right: 8px; font-weight: bold;color: #ffffff">
                <a style="text-decoration: none;color:#ff143f;font-size: 15px" href="<?php echo U('Admin/AdminNav/add_nav');?>">【添加菜单】</a>
            </span>
        </span>
    </div>
    <div style="font-size: 13px; margin: 10px 5px;">
    <table class="table_a" style="border:1px solid rgba(119, 163, 218, 0.79)" width="100%">
        <thead>
        <tr style="height:35px;color: #ffffff;font-weight: bold;background-color:  rgb(129, 191, 249);">
            <th>排序</th>
            <th>菜单名</th>
            <th>链接</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            <?php if(is_array($navList)): $i = 0; $__LIST__ = $navList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><tr>
                    <td width="100">
                        <input type="text" id="pri<?php echo ($value["id"]); ?>" value="<?php echo ($value["priority"]); ?>" onchange="setPriority(this,<?php echo ($value["id"]); ?>)"  style="height:30px;width: 50px"/>
                    </td>
                    <td><?php echo str_repeat('&nbsp;',12*($value['level']-1));?>|--<?php echo ($value["navname"]); ?></td>
                    <td><?php echo ($value["navurl"]); ?></td>
                    <td>
                        <a href="<?php echo U('add_nav',array('pid'=>$value['id'],'pname'=>$value['navname']));?>" class="tablelink">添加子菜单</a>&nbsp;&nbsp;
                        <a href="<?php echo U('edit',array('id'=>$value['id']));?>" class="tablelink">编辑</a>&nbsp;&nbsp;
                        <a href="#" id="<?php echo ($value['id']); ?>" class="tablelink del">删除</a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
<script>
    //删除
    $('.del').click(function(){
        var id=$(this).attr('id');
        $.post("<?php echo U('del');?>",{id:id},function(res){
            if(res.status==1){
                layer.msg(res.info,{icon:1},function(){
                    location.href=res.url;
                })
            }else{
                layer.msg(res.info,{icon:5});
            }
        })
    });
    //更改排序
    function setPriority(nav,id){
        var priority=$(nav).val();
        $.post("<?php echo U('setPriority');?>",{'priority':priority,'id':id},function(res){
            if(res.status==1){
                layer.tips(res.info, '#pri'+id, {
                    tips: [2, '#3EAFE0']
                });
            }
        })
    }
</script>