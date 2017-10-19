<?php
namespace Admin\Model;
use Think\Model;
class EnvironmentModel extends Model {
    //查询一条或多条记录
    public function environment_list($where='',$field='',$num=0,$order='',$limit=''){
        if($num==1){
            $data=$this->where($where)->field($field)->order($order)->limit($limit)->select();
        }else{
            $data=$this->where($where)->field($field)->order($order)->limit($limit)->find();
        }
        return $data;
    }
}