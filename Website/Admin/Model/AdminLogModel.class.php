<?php
namespace Admin\Model;
use Think\Model;
class AdminLogModel extends Model{
/*
 * 沈艳艳     //添加学员时添加订单日志
 * @param array $log 添加的数组
 * @param string $res 添加的日志的最后的id值
*/
    public function addOrderLog($log,$oid){
        //添加日志
        if ($log) {
            $OrderLog['lastip'] = I("server.REMOTE_ADDR");
            $OrderLog['ntime'] = time();
            $OrderLog['oid'] = $oid;
            $OrderLog['uid'] = session('admin_id');
            $OrderLog['done'] = $log;
            $res = M('OrderLog')->add($OrderLog);
            if ($res) {
                return $res;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

/*
 * 沈艳艳     //退出/修改口令 日志
 * @param array $log 添加的数组
 * @param string $res 添加的日志的最后的id值
*/
    public function logout($log){
        $log['lastip'] = I("server.REMOTE_ADDR");
        $log['uid'] = session('admin_id');
        $log['ntime'] = time();
        $res = $this->add($log);
        if ($res) {
            return $res;
        } else {
            return 0;
        }
    }
/*
 * User: 沈艳艳
 * Date: 2017/08/21
 *Time: 13:43
 *@return array $order_log 订单操作日志
 *订单详情的操作日志
*/
    public function order_log($oid){
        $order_log = M('OrderLog')->alias('ol')
            ->join('xueches_admin a ON a.id=ol.uid')
            ->field('a.username,ol.ntime,ol.done,ol.lastip')
            ->where(array('ol.oid'=>$oid))
            ->order('ol.ntime')->select();
        return $order_log;
    }
/*--------------------------2017-12-08shenyanyan------------------------*/
//导出管理员、订单日志
    public function push($get,$t = ''){
        if($t){
            $admins = M('OrderLog');
            $table = 'xueches_admin a,xueches_order_log al,xueches_order o';
            $where = ' al.uid=a.id and al.oid=o.id ';
            $field = 'a.username,al.done,al.ntime,al.lastip,al.id,o.ordcode';
        }else{
            $admins = M('AdminLog');
            $table = 'xueches_admin a,xueches_admin_log al';
            $where = ' al.uid=a.id ';
            $field = 'a.username,al.done,al.ntime,al.lastip,al.uid,al.id';
        }
        $admin = M('Admin')->where(array('id'=>session('admin_id')))->find();
        if($admin['permissions'] == 2){//超级管理员1可查看所有人的订单,普通管理员2只能查看自己的订单
            $get['uid'] = session('admin_id');
        }else{
            $get['uid'] = I('uid');
        }
        if(!empty($get)){
            if($get['stop_time']){
                $where .=" and al.ntime < '{$get['stop_time']}' and al.uid = {$get['uid']}";
            }else{
                foreach($get as $key=>$val) {
                    if($key == 'ntime' && $val != ''){
                        $val = strtotime(trim($val));
                        $where.="and al.ntime  >= $val ";
                    }elseif($key == 'ntime1' && $val != ''){
                        $val = strtotime(trim($val));
                        $where.="and al.ntime  <= $val ";
                    } elseif($key == 'uid' && $val != ''){
                        $where.="and al.uid = $val ";
                    } elseif($key == 'start_time' && $val != ''){
                        $where.="and al.ntime >= $val ";
                    }
                }
            }
        }
        $list = $admins->table($table)->where($where)->field($field)->select();
        $name = 'Excelfile';    //生成的Excel文件文件名
        if($get['stop_time']){
            if($t){
                M('OrderLog')->where(array('ntime'=>array('lt',$get['stop_time'])))->delete();
            }else{
                M('AdminLog')->where(array('ntime'=>array('lt',$get['stop_time'])))->delete();
            }
        }
        if($t){
            $res = push_data1($list,$name);
        }else{
            $res = push_data($list,$name);
        }
        return $res;
    }

}

