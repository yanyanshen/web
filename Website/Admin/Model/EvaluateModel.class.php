<?php
namespace Admin\Model;
use Think\Model;
class EvaluateModel extends Model{
    /*
     * User：沈艳艳
     * Date：2017/08/30
     * @param $get array 条件
     * @param $field string 字段
     * return $evaluate array 返回用户评价列表
     */
    public function evaluate_list($get='',$field){
        if(!empty($get)){
            foreach($get as $key=>$val) {
                if($key == 'create_time1' && $val != ''){
                    $where.=" ntime > $val and ";
                }elseif($key == 'create_time2' && $val != ''){
                    $where.=" ntime < $val and ";
                }elseif($key == 'flag'){
                    $where.=" $key = 0  and  ";
                }elseif($key == 'nickname'){
                    $info = M('school')->field('id')->where(array('nickname'=>array('like',"%$val%")))->select();
                    foreach($info as $v){
                        $str .= $v['id'].',';
                    }
                    $id = substr($str,0,-1);
                    $where.=" sid in ($id)  and  ";
                }elseif($key == 'id'){
                    $where.=" id = $val";
                }
            }$where = rtrim($where,'and ');
        }
        $count = M('Evaluate')->where($where)->count();
        $page = new \Think\Page($count,10);
        $evaluate = $this->where($where)->field($field)->limit($page->firstRow.','.$page->listRows)
            ->order('ntime desc')->select();//用户评价
        foreach($evaluate as $k=>$v){
            $evaluate[$k]['untime'] = M('EvaluateUntil')->where(array('eid'=>$v['id']))->getField('ntime');
            $evaluate[$k]['ucontent'] = M('EvaluateUntil')->where(array('eid'=>$v['id']))->getField('content');
            $evaluate[$k]['nickname'] = M('School')->where(array('id'=>$v['sid'],"nickname like '%{$get['nickname']}%'"))->getField('nickname');
        }
        $arr[0] = $evaluate;
        $arr[1] = $count;
        $arr[2] = $page->show();
        $arr[3] = $page->firstRow;
        return $arr;
    }
/*
 * User：沈艳艳
 * Date：2017/08/31
 * @param $id string 某一条评论的id值
 * return $info 某一条评论的信息
 */
    public function evaluate_reply($id){
        $this->evaluate_list($id);
    }
}