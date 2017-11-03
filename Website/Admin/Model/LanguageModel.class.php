<?php
namespace Admin\Model;
use Think\Model;
use Think\Page;
class LanguageModel extends Model{
/*----------------------2017-10-24获取语言列表shenyanyan----------------------*/
/*
 * @param $get array 查询的条件
 * return $list array 返回根据条件获得 语言列表
*/
    public function index($get){
        $where = "l.cityid=city.id";
        foreach($get as $k=>$v){
            if($k=='cityid' && $v != 0){
                $where.=" and l.cityid ={$get['cityid']} ";
            }elseif($k=='nickname' && $v != ''){
                $where.=" and l.nickname like '%".trim($get['nickname'])."%' ";
            }
        }
        $count = $this->table('xueches_language l,xueches_citys city')->where($where)->count();
        $Page=new Page($count,8);
        $show=$Page->show();
        $data = M('Language')
            ->field('l.*,city.cityname')
            ->table('xueches_language l,xueches_citys city')
            ->where($where)
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();
        $list['list'] = $data;
        $list['count'] = $count;
        $list['page'] = $show;
        $list['firstRows'] = $Page->firstRow;
        return $list;
    }
/*
 * @param $post array 查表单内容
 * return $id 返回根据最后一个插入的id值
*/
    public function add_language($post){
        $info = $this->where(array('nickname'=>$post['nickname'],'cityid'=>$post['cityid']))->getField('id');
        if($info){
            $id = 0;
        }else{
            $id = $this->add($post);
            $log['done'] = '添加教育语言';
            D('AdminLog')->logout($log);
        }
        return $id;
    }
}