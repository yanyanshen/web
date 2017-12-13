<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>ClientIps列表</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script src="/Public/public/js/layer/layer.js"></script>
    <script  src="/Public/public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
    <div class="div_head">
        ClientIps列表
        <a style="text-decoration: none;color:#fa7124;" href="<?php echo U(add_ips,array('pid'=>$get['pid'],'p'=>$get['p']));?>">【ClientIps添加】</a>
        <span class="span">总计：<?php echo ($count); ?></span>
    </div>
    <div class="div_search">
        <span>
            <form action="?" id='form1' method="get" name="form1">
                <span>
                    IP：<input type="text" name='ip' style="width: 100px"  value="<?php echo ($get['ip']?$get['ip']:''); ?>" />
                </span>
                <span style="padding-left: 5px">
                    最后更新人：<input type="text" name='last_name' style="width: 100px"  value="<?php echo ($get['last_name']?$get['last_name']:''); ?>" />
                </span>
                   <span style="padding-left: 5px">
                    城市：<input type="text" name='cityname' style="width: 100px"  value="<?php echo ($get['cityname']?$get['cityname']:''); ?>" />
                </span>
                <span style="padding-left: 5px">
                    添加时间：<input type="text" style="width: 120px;"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" value="<?php echo ($get['ntime1']?$get['ntime1']:''); ?>" name="ntime1"/>
                    至
                    <input type="text" style="width: 120px;" value="<?php echo ($get['ntime2']?$get['ntime2']:''); ?>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" name="ntime2"/>
                </span>
                <input style="font-size: 11px" value="查询" type="submit" id='btn' onclick="submitYouFrom('<?php echo U("Admin/ClientIps/index",array('pid'=>$get['pid'],'p'=>$get['p']));?>')"/>
                <input  style="font-size: 11px" value="清空" type="reset" id="btn"/>
                <script type="text/javascript" language="javascript">
                    function submitYouFrom(path){
                        $('#form1').attr('action',path);
                        $('#form1').submit();
                    }
                </script>
            </form>
        </span>
    </div>
    <div style="margin-left: 6px">
        <input id="checkall" style="font-size: 12px;font-weight: bold;background-color:rgb(247, 247, 247);border-radius: 3px;border:none;color: #646464;width: 60px;padding: 2px 0;" type="button" value='全选' />
        <input type="button" value='删除' onclick="batch_operate_del()" style="font-size: 12px;font-weight:bold;background-color:rgb(247, 247, 247);border-radius: 3px;border:none;color: #646464;width: 60px;padding: 2px 0"/>
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

            function batch_operate_del(){
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
                        layer.msg('确定要删除吗？',{
                            time:0,
                            btn:['确定','取消'],
                            yes:function(){
                                location.href = "<?php echo U('Admin/ClientIps/batch_operate_del');?>?pid=<?php echo ($get['pid']); ?>&p=<?php echo ($get['p']); ?>&str="+res.info['str']
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
    <table class="table_a">
        <tbody>
            <tr style="background-color:rgb(19, 181, 177);">
                <th width="2%">ID</th>
                <th width="5%">IP</th>
                <th width="5%">城市</th>
                <th width="4%">IP描述</th>
                <th width="5%">添加时间</th>
                <th width="5%">编辑时间</th>
                <th width="5%">状态</th>
                <th width="5%">操作</th>
            </tr>
            <form action="" id="form2">
                <?php if(is_array($iplist["iplist"])): $k = 0; $__LIST__ = $iplist["iplist"];if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                        <td><input type="checkbox" value="<?php echo ($v["id"]); ?>" name="id[]"/><?php echo ($v["id"]); ?></td>
                        <td><?php echo ($v["ip"]); ?></td>
                        <td><?php echo ($v["cityname"]); ?></td>
                        <td><?php echo ($v["description"]); ?></td>
                        <td><?php echo ($v['ntime']); ?></td>
                        <td><?php echo ($v['edit_time']); ?></td>
                        <td><?php echo ($v['status']?'开启':'禁止'); ?></td>
                        <td><a class="tablelink" href="<?php echo U('Admin/ClientIps/edit_ips',array('pid'=>$get['pid'],'id'=>$v['id'],'p'=>$get['p']));?>">编辑</a></td>
                    </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
            </form>
        </tbody>
    </table>
    <div id="page"><?php echo ($iplist['page']); ?></div>
</div>
</body>
</html>