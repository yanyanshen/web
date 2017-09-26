<?php
namespace Admin\Model;
use Think\Model;
class AdminNavModel extends Model{
/*
 *return $navList array 菜单
*/
    public function getNavList(){
        $navList=$this->order('priority asc')->select();
        foreach($navList as $k=>$v){
            $count=count(explode(',',$v['path']));
            $navList[$k]['level']=$count;
        }
        return $navList;
    }
/*
@param $post array 表单提交过来的数据
*/
    public function add_nav($post){
        $nid=$this->field("pid,navname,navurl,priority")->add($post);
        if($nid){
            if($post['pid']==0){
                $path=$nid;
            }else{
                $path=$this->where(array('id'=>$post['pid']))->getField('path');
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
// 显示有权限的菜单
    public function getNavTree(){
        $nav=$this->where(array('pid'=>0))->order('priority')->select();
        if($nav){
            $auth=new \Think\Auth();
            foreach($nav as $k1=>$v1){
                if ($auth->check($v1['navurl'],session('admin_id'))) {
                    $child=$this->where(array('pid'=>$v1['id']))->order('priority')->select();
                    foreach($child as $k2=>$v2){
                        if (!$auth->check($v2['navurl'],session('admin_id'))) {
                            // 删除无权限的菜单
                            unset($child[$k2]);
                        }
                    }
                    $nav[$k1]['child']=$child;
                }else{
                    // 删除无权限的菜单
                    unset($nav[$k1]);
                }
            }
            return $nav;
        }else{
            return false;
        }
    }
//设置权限
    public function setPriority($data){
        $row=$this->save($data);
        return $row;
    }
}