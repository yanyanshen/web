<?php
namespace Admin\Model;
use Think\Model;
class LandmarkModel extends Model {
    //自动验证定义
    protected $patchValidate=true;
    protected $_validate =array(
        //array(字段，验证规则，错误提示，验证条件，附加规则，验证时间);
        //1用户名不为空，并且唯一
        array('landname','require','地标名不能为空'),
        array('landname','','该地标已存在',0,'unique'),
    );

    public function lands_list($where,$field='',$num=0,$order='',$limit=''){
        if($num==1){
            $data=$this->where($where)->field($field)->select();
        }else{
            $data=$this->where($where)->field($field)->find();
        }
        return $data;
    }

    public function land_save($where,$data){
       $res=$this->where($where)->save($data);
        return $res;
    }

    public function land_add($data){
        $res=$this->add($data);
        return $res;
    }
    public function land_del($id){
        $res=$this->where(array('id'=>$id))->delete();
        return $res;
    }

}
