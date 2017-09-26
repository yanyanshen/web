<?php
namespace Mobile\Common\Controller;
use Think\Controller;
class CommonController extends Controller{
    public function __construct(){
        parent::__construct();
        if(!session('mid')){
            $this->redirect('Mobile/Login/login');
        }
    }
}

