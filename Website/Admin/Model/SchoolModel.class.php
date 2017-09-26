<?php
namespace Admin\Model;
use Think\Model;
class SchoolModel extends Model {
    public function add_jx($data){
        $id=$this->add($data);
        return $id;
    }
    //编辑
    public function jx_editor($where,$data){
        $id=$this->where($where)->save($data);
        return $id;
    }


    //查询一条或多条记录
    public function school_list($where='',$field='',$order='',$limit='',$num=0){
        if($num==1){
            $data=$this->where($where)->field($field)->order($order)->limit($limit)->select();
        }else{
            $data=$this->where($where)->field($field)->order($order)->limit($limit)->find();
        }
        return $data;
    }

    public function setPriority($data){
        $row=$this->save($data);
        return $row;
    }
}