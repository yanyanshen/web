<?php
namespace Mobile\Model;
use Think\Model;
class SlideshowModel extends Model{
/*
 * User：沈艳艳
 * Date：2017/09/08
 * 轮播图
 * @param $where string 查询条件
 */
    public function slideshow($where){
        $info = $this->where($where)->select();
        foreach($info as $k=>$v){
            if($v['type'] == 1){
                $info[$k]['href'] = "{$v['city_pinyin']}/{$v['url']}{$v['param']}";
            }else{
                $info[$k]['href'] = '';
            }
        }
        return $info;
    }
}