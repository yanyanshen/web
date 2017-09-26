<?php
namespace Admin\Model;
use Think\Model;
class CitysModel extends Model {
    //城市表一条或多条记录查询
    public function city_one($where,$field='',$num=0,$order='',$limit=''){
        if($num==1){
            $data=$this->where($where)->field($field)->select();
        }else{
            $data=$this->where($where)->field($field)->find();
        }
        return $data;
    }
}
