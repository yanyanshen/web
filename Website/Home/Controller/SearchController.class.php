<?php
namespace Home\Controller;
use Think\Controller;
class SearchController extends Controller
{
    public function index()
    {
        $this->assign('k', I('k'));
//        print_r(I('k'));
        dump(I('lng'));
        dump(I('lat'));
        $this->assign('lng', I('lng'));
        $this->assign('lat', I('lat'));
        $this->assign('condition', I('condition'));
        $this->display();
    }
}