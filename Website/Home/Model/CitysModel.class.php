<?php
namespace Home\Model;
use Think\Model;
class CitysModel extends Model{
    public function getCityId($where){
        $id=$this->where($where)->field('citys_name,id')->find();
        return $id;
    }
}