<?php
namespace Home\Model;
use Think\Model;
class UsersModel extends Model{
    //得到选择的城市
    public function getUsers_city($where){
        $city=$this->where($where)->getField('users_city');
        return $city;
    }
    public function saveInfo($where='',$data){
        $info=$this->where($where)->save($data);
        return $info;
    }
}