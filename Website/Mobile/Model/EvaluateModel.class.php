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
        $evaluate = $this->field('id,truename,content,ntime,score,append')
            ->where(array('sid'=>$id))->order('ntime desc')->limit(0,$limit)->select();//用户评价
        foreach($evaluate as $k=>$v){
            $evaluate[$k]['untime'] = M('EvaluateUntil')->where(array('eid'=>$v['id']))->getField('ntime');
            if($v['append']){
                $evaluate[$k]['ucontent'] = M('EvaluateUntil')->where(array('eid'=>$v['id']))->getField('content');
            }
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
        if(session('until')){
            $where = "sid = {$post['id']} and append = 1";
        }else{
            $where = "sid = {$post['id']}";
        }
        foreach($post as $k=>$v){
            if($k == 'total'){
                $where .= '';
            }elseif($k == 'new'){
                $date = date('Y-m-t',strtotime('-1 month'));
                $where .= " and ntime > '$date'";
            }
        }
        $num = 15;
        $page = $post['page']?$post['page']:1;
        $evaluate = $this->field('id,content,ntime,score,append,sid,truename')
            ->where($where)->page($page,$num)->order('ntime desc')->select();//用户评价
        foreach($evaluate as $k=>$v){
            $evaluate[$k]['untime'] = M('EvaluateUntil')->where(array('eid'=>$v['id']))->getField('ntime');
            if($v['append']){
                $evaluate[$k]['ucontent'] = M('EvaluateUntil')->where(array('eid'=>$v['id']))->getField('content');
            }
            $evaluate[$k]['reply'] = M('EvaluateReply')->field('content,ntime')->order('ntime desc')->where(array('eid'=>$v['id']))->select();
        }
        return $evaluate;
    }
}