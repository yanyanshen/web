<?php
namespace Mobile\Model;
use Think\Model;
class EvaluateModel extends Model{
/*
 * User：沈艳艳
 * Date：2017/08/30
 * @param $id string 驾校id
 * @param $limit string 查询几条数据
 * return $evaluate array 返回用户评价列表
 */
    public function index($id,$limit=''){
        $evaluate = $this->alias('e')
            ->join('xueches_user u ON u.id=e.uid')
            ->field('e.id,u.truename,e.content,e.ntime,e.score')
            ->where(array('sid'=>$id))
            ->order('e.ntime desc')
            ->limit(0,$limit)->select();//用户评价
        foreach($evaluate as $k=>$v){
            $evaluate[$k]['untime'] = M('EvaluateUntil')->where(array('eid'=>$v['id']))->getField('ntime');
            $evaluate[$k]['ucontent'] = M('EvaluateUntil')->where(array('eid'=>$v['id']))->getField('content');
            $evaluate[$k]['reply'] = M('EvaluateReply')->field('content,ntime')->order('ntime desc')->where(array('eid'=>$v['id']))->select();
        }
        return $evaluate;
    }

/*
* User：沈艳艳
* Date：2017-09-12
* 驾校详情评价列表
*@param $post array 条件
*@param $id 驾校的id值 条件
*/
    public function  evaluate($post){
        $where = "e.sid = {$post['id']}";
        foreach($post as $k=>$v){
            if($k == 'total'){
                $where .= '';
            }elseif($k == 'new'){
                $date = date('Y-m-t',strtotime('-1 month'));
                $where .= " and e.ntime > '$date'";
            }
        }
        $num = 2;
        $page = $post['page']?$post['page']:1;
        $evaluate =  $this->alias('e')
            ->join('xueches_user u ON u.id=e.uid')
            ->field('e.id,u.truename,e.content,e.ntime,e.score')
            ->where($where)
            ->page($page,$num)->select();//用户评价
        foreach($evaluate as $k=>$v){
            $evaluate[$k]['untime'] = M('EvaluateUntil')->where(array('eid'=>$v['id']))->getField('ntime');
            $evaluate[$k]['ucontent'] = M('EvaluateUntil')->where(array('eid'=>$v['id']))->getField('content');
            $evaluate[$k]['reply'] = M('EvaluateReply')->field('content,ntime')->order('ntime desc')->where(array('eid'=>$v['id']))->select();
        }

        if($post['until']){
            foreach($evaluate as $k1=>$v1){
                if($v1['ucontent'] == ''){
                    unset($evaluate[$k1]);
                }
            }
        }
        return $evaluate;
    }
}