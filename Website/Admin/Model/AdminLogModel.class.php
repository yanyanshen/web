<?php
namespace Admin\Model;
use Think\Model;
class AdminLogModel extends Model{
/*
 * 沈艳艳     //添加学员时添加订单日志
 * @param array $log 添加的数组
 * @param string $res 添加的日志的最后的id值
*/
    public function addOrderLog($log)
    {
        //添加日志
        if ($log) {
            $OrderLog['lastip'] = I("server.REMOTE_ADDR");
            $OrderLog['ntime'] = time();
            $OrderLog['oid'] = session('oid');
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
    public function order_log(){
        $order_log = M('OrderLog')->alias('ol')
            ->join('xueches_admin a ON a.id=ol.uid')
            ->field('a.username,ol.ntime,ol.done,ol.lastip')
            ->where(array('ol.oid'=>session('oid')))
            ->order('ntime desc')
            ->select();
        return $order_log;
    }
}

