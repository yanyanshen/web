<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>指导员排行榜</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script src="/Public/public/js/layer/layer.js"></script>
</head>
<body>
<div class="div_head">
    指导员排行榜
    <span class="span">总计：<?php echo ($count); ?></span>
</div>
<!--<div class="div_search">-->
    <!--<span>-->
        <!--<form action="<?php echo U('Admin/Coach/coach_top',array('pid'=>$get['pid']));?>" id='form' method="get">-->
            <!--驾校简称：<input type="text" name='nickname' value="<?php echo ($nickname?$nickname:''); ?>" />-->
            <!--驾校账号：<input type="text" name='account' value="<?php echo ($account?$account:''); ?>"/>-->
            <!--<input style="font-size: 11px" value="查询" type="submit" id='btn'/>-->
            <!--<input style="font-size: 11px" value="清空全部" type="reset" id=''/>-->
        <!--</form>-->
    <!--</span>-->
<!--</div>-->
<div style="margin-left: 6px">
    <input id="checkall" style="font-size: 12px;font-weight: bold;background-color:rgb(247, 247, 247);border-radius: 3px;border:none;color: #646464;width: 60px;padding: 2px 0;" type="button" value='全选' />
    <input type="button" value='取消' onclick="cancel('guider_top')" style="font-size: 12px;font-weight:bold;background-color:rgb(247, 247, 247);border-radius: 3px;border:none;color: #646464;width: 60px;padding: 2px 0"/>
    <span style="color: #FA7124;">注意：前端页面最多可放6个以防止排版杂乱多余的可取消</span>
    <script>
        $("document").ready(function(){
            $("#checkall").click(function(){
                if($(this).val() == '全选'){
                    $("input[type='checkbox']").prop('checked',true);
                    $("#checkall").val('取消全选');
                }else{
                    $("input[type='checkbox']").prop('checked',false);
                    $("#checkall").val('全选');
                }
            });
        });

        function cancel(type){
            var id_arr = document.getElementsByName('id[]');
            var flag = false;
            for(var i in id_arr){
                if(id_arr[i].checked){
                    flag = true;
                    break;
                }
            }
            if(flag){
                $.post("<?php echo U('Admin/Finance/batch_operate');?>",$("#form2").serialize(),function(res){
                    layer.msg('确定要取消吗？',{
                        time:0,
                        btn:['确定','取消'],
                        yes:function(){
                            location.href = "<?php echo U('Admin/School/cancel');?>?pid=<?php echo ($get['pid']); ?>&str="+res.info['str']+"&type="+type
                        }
                    });
                },'json')
            }else{
                layer.msg('请勾选后再操作',{time:2000,btn:['知道了']});
            }
        }
    </script>
</div>
<div style="margin: 10px 5px;">
    <table class="table_a" width="100%">
        <tbody>
            <tr style="background-color: rgb(19, 181, 177);">
                <th width="1%"></th>
                <th width="2%">排序</th>
                <th width="3%">账号</th>
                <th width="5%">驾校简称</th>
                <th width="3%">头像</th>
                <th width="3%">城市</th>
                <th width="3%">学员</th>
                <th width="3%">教练</th>
                <th width="3%">评分</th>
                <th width="4%">驾校联系人</th>
            </tr>
            <form action="" id="form2">
                <?php if(is_array($jx_list)): $k = 0; $__LIST__ = $jx_list;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                        <td><input type="checkbox" name="id[]" value="<?php echo ($v["school_id"]); ?>"/></td>
                        <td>
                            <input type="text" value="<?php echo ($v["order"]); ?>" id="pri<?php echo ($v["school_id"]); ?>" onchange="setPriority(this,<?php echo ($v["school_id"]); ?>)" style="width: 30px;text-align: center"/>
                        </td>
                        <td><?php echo ($v["account"]); ?></td>
                        <td><?php echo ($v["nickname"]); ?></td>
                        <td>
                            <?php if($v['picname'] != ''): ?><img src="<?php echo ($http); ?>/Uploads/guider_logo/<?php echo ($v['picurl']); echo ($v['picname']); ?>" alt="" style="border-radius:50%" width="50" height="40" />
                                <?php else: ?>
                                <img src="<?php echo ($http); ?>/Uploads/default_logo/517.png" alt="" style="border-radius:50%" width="50" height=40" /><?php endif; ?>
                        </td>
                        <td><?php echo ($v["cityname"]); ?></td>
                        <td><?php echo ($v["student_num"]); ?>个学员</td>
                        <td><?php echo ($v["coach_num"]); ?>个教练</td>
                        <td><?php echo ($v["score"]); ?></td>
                        <td><?php echo ($v["connectteacher"]); ?></td>
                    </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
            </form>
        </tbody>
    </table>
    <div id="page">
        <?php echo ($page); ?>
    </div>
</div>
</body>
</html>

<script>
    function setPriority(nav,id){
        var priority=$(nav).val();
        $.post("<?php echo U('Admin/School/setPriority');?>",{'order':priority,'id':id},function(res){
            if(res.status==1){
                layer.tips(res.info, '#pri'+id, {
                    tips: [2, '#3EAFE0'],
                    end: function(){
                        location.href=res.url;
                    }
                });
            }
        },'json')
    }
</script>