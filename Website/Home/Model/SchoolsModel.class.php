<?php
namespace Home\Model;
use Think\Model;
class SchoolsModel extends Model{
    public function getSchoolList($where,$order,$limit='',$lng='',$lat=''){
        if($lng!=''||$lat!=''){
            $data=$this->where($where)
                ->field('schools_name,id,schools_price,schools_num,schools_order,schools_search,schools_nowPrice')
                ->order($order)
                ->limit($limit)
                ->select();
            return $data;
        }else{
            $data=$this->where($where)
                ->field('schools_name,id,schools_price,schools_num,schools_order,schools_search,schools_nowPrice')
                ->order($order)
                ->limit($limit)
                ->select();

        }

    }
    //驾校详细列表
    public function getHotList($where,$order,$type_name,$limit=''){
        $dataInfo=$this->where($where)
            ->field('schools_name,id,schools_num,schools_order')
            ->order($order)
            ->limit($limit)
            ->select();
        foreach($dataInfo as $k=>$v){
            $dataInfo[$k]['type_name']=M('scategory')->where(array('schools_id'=>$v['id'],'type_name'=>$type_name))->getField('type_name');
            $dataInfo[$k]['schools_nowprice']=M('scategory')->where(array('schools_id'=>$v['id'],'type_name'=>$type_name))->getField('category_nowprice');
            $dataInfo[$k]['schools_price']=M('scategory')->where(array('schools_id'=>$v['id'],'type_name'=>$type_name))->getField('category_price');
        }
        return $dataInfo;
    }
}