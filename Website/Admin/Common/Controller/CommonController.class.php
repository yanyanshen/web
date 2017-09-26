<?php
namespace Admin\Common\Controller;
use Think\Controller;
class CommonController extends Controller{
    public function __construct(){
        parent::__construct();
        if(!session('admin_id')){
            $this->redirect('Admin/Login/login');
        }
    }
}

