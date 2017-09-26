<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model {
/*
 * @param $post array 表单提交过来的数据
 * @return $result string 最后一条插入的数据的id值
 */
    public function add_admin($post){
        $result = $this->add($post);
        return $result;
    }
    public function getAdminList(){
        $adminList=$this->select();
        return $adminList;
    }

    public function getAdminById($id){
        $admin=$this->find($id);
        return $admin;
    }
//编辑管理员
    public function editAdmin($data){
        $row=$this->save($data);
        return $row;
    }

/*
 * @param $post array //管理员修改口令
 * @return $row string 修改的行数
 */
    public function edit_pass($data){
        $row = $this->save($data);
        return $row;
    }
}
