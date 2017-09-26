<?php
namespace Admin\Model;
use Think\Model;
class AuthGroupModel extends Model{
//获取权限组列表
    public function getGroupList(){
        $groupList=$this->select();
        return $groupList;
    }
//管理组添加
    public function add_group($data){
        $gid=$this->field("title")->add($data);
        return $gid;
    }
//编辑权限
    public function editRule($data){
        $row=$this->save($data);
        return $row;
    }
}