<?php
namespace Mobile\Model;
use Think\Model;
class UserLogModel extends Model{
/*
 * User：沈艳艳
 * Date：2017/08/28
 * 添加用户日志
 */
    public function add_user_log($log){
        $log['lastip'] = I("server.REMOTE_ADDR");
        $log['ntime'] = date('Y-m-d');
        $res = $this->add($log);
        if ($res) {
            return $res;
        } else {
            return 0;
        }
    }
}