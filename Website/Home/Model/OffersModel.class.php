<?php
namespace Home\Model;
use Think\Model;
class OffersModel extends Model{
    public function getOfferList($where,$order,$limit=''){
        $id=$this->where($where)
            ->field('offers_name,id,offers_price,offers_num,offers_order,offers_search')
            ->order($order)
            ->limit($limit)
            ->select();
        return $id;
    }
}