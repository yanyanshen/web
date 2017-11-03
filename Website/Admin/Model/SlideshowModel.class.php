<?php
namespace Admin\Model;
use Think\Model;
class SlideshowModel extends Model {
    //查询一条或多条记录
    public function slideshow_list($where='',$field='',$num=0,$order=''){
        if($num==1){
            $count = $this->where($where)->count();
            $page = new \Think\Page($count,7);
            $show = $page->show();
            $info = $this->where($where)
                ->field($field)
                ->order($order)
                ->limit($page->firstRow.','.$page->listRows)
                ->select();
            $data['page'] = $show;
            $data['count'] = $count;
            $data['info'] = $info;
        }else{
            $data=$this->where($where)->field($field)->order($order)->limit($limit)->find();
        }
        return $data;
    }

}