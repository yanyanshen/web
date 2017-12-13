<?php
namespace Home\Model;
use Think\Model;
class SchoolModel extends Model{
    public function schools_list($where,$order){
        $data = $this->where($where)->alias('s')->order($order)->select();
        return $data;
    }
    //驾校详细列表
    public function getHotList($where,$order,$field,$min='',$high=''){
        $dataInfo=$this->where($where)->alias('s')->field($field)
            ->order($order)->limit($min,$high)->select();
        return $dataInfo;
    }
}