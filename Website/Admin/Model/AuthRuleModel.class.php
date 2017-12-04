<?php
namespace Admin\Model;
use Think\Model;
class AuthRuleModel extends Model{
//得到权限列表
    public function getRuleList(){
        $navList=$this->order('path asc')
            ->select();
        foreach($navList as $k=>$v){
            $count=count(explode(',',$v['path']));
            $navList[$k]['level']=$count;
        }

        return $navList;
    }
//添加权限;
    public function add_rule($data){
        $nid=$this->field("pid,title,name")->add($data);
        if($nid){
            if($data['pid']==0){
                $path=$nid;
            }else{
                $path=$this->where(array('id'=>$data['pid']))->getField('path');
                $path.=','.$nid;
            }
            $save['path']=$path;
            $save['id']=$nid;
            $row=$this->save($save);
            return $row;
        }else{
            return $nid;
        }
    }

//显示三级联动
    public function getRuleByPid($pid){
        $rule=$this->where(array('pid'=>$pid))->select();
        if($rule){
            return $rule;
        }else{
            return false;
        }
    }
//编辑权限;
    public function edit($data){
        $row=$this->save($data);
        return $row;
    }
//分配权限的列表
    public function getRuleTree(){
        $rule=$this->where(array('pid'=>0))->select();
        if($rule){
            foreach($rule as $k=>$v){
                $child=$this->where(array('pid'=>$v['id']))->select();
                foreach($child as $k1=>$v1){
                    $child1=$this->where(array('pid'=>$v1['id']))->select();
                    $child[$k1]['child']=$child1;
                }
                $rule[$k]['child']=$child;
            }
            return $rule;
        }else{
            return false;
        }
    }

/* User: 沈艳艳
 * Date: 2017/08/24
 * 得到菜单下的子权限
 * @param $pid string 子菜单的上级id
 * @param $type 子菜单类型
 * return array $rule 得到子权限数据
 */
    public function getRule($pid,$type){
        $rule = M('AuthRule')->field('id,title,name')->where(array('pid'=>$pid,'title'=>$type))->find();
        $rules = M('AuthGroup')->alias('ag')
            ->join('xueches_auth_group_access aga ON ag.id = aga.group_id')
            ->field('aga.uid,aga.group_id,ag.rules')
            ->where(array('aga.uid'=>session('admin_id')))->find();

        if($rule&&$rules['rules']){
            $id = M('AuthGroup')->where(array('id'=>$rules['group_id'],"{$rule['id']} in ({$rules['rules']})"))->getField('id');

            if($id){
                return $rule;
            }else{
                return $rule = array('name'=>0);
            }
        }else{
            return $rule = array('name'=>0);
        }
    }
}
