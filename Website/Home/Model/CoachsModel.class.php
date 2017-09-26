<?php
namespace Home\Model;
use Think\Model;
class CoachsModel extends Model{
    public function getCoachList($where,$order,$limit=''){
        $id=$this->where($where)
            ->field('coachs_name,id,coachs_price,coachs_num,coachs_order,coachs_search')
            ->order($order)
            ->limit($limit)
            ->select();
        return $id;
    }
}