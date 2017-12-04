<?php
namespace Admin\Model;
use Think\Model;
class ClientIpsModel extends Model{
/*-------------------------------2017-12-04shenyanyan------------------------*/
//ClientIps列表
    public function index($get){
        if(!empty($get)){
            foreach($get as $key=>$val) {
                if($key == 'ip' && $val != ''){
                    $where.=" $key like '%".trim($get['ip'])."%' and";
                }elseif($key == 'last_name' && $val != ''){
                    $where.=" $key like '%".trim($val)."%' and";
                }elseif($key == 'ntime1' && $val != ''){//下单时间
                    $where.=" ntime > '$val' and";
                }elseif($key == 'ntime2' && $val != ''){
                    $where.=" ntime  < '$val' and";
                }
            }$where = rtrim($where,'and');
        }
        $iplist = $this->where($where)->select();
        return $iplist;
    }
}