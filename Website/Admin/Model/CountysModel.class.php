<?php
namespace Admin\Model;
use Think\Model;
class CountysModel extends Model {
    //城市表一条或多条记录查询
    public function Countys_list($where,$field='',$num=0,$order='',$limit=''){
        if($num==1){
            $data=$this->where($where)->field($field)->select();
        }else{
            $data=$this->where($where)->field($field)->find();
        }
        return $data;
    }
}
