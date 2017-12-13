<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Controller\CommonController;
class UserLogController extends CommonController{
/*
 * User：沈艳艳
 * Date：2018/08/28
 * 用户日志展示
 */
    public function index(){
        $_GET['start_time'] = date('Y-m-d 00:00:00' , strtotime('-2 month'));
        if (IS_GET) {
            //搜索;
            foreach($_GET as $key=>$val){
                if($key == 'ntime' && $val != ''){
                    $where.="ul.ntime >= '$val' and ";
                }elseif($key == 'ntime1' && $val != ''){
                    $where.="ul.ntime  <= '$val' and ";
                }elseif($key == 'start_time' && $val != ''){
                    $where.="ul.ntime  >= '$val' and ";
                }elseif($key == 'username' && $val != ''){
                    $where.="u.truename like '%".trim($val)."%' and ";
                }
            }$where = rtrim($where,'and ');
        }
        $count = M('UserLog')->alias('ul')->join('xueches_user u ON u.id = ul.uid')->where($where)->count();
        $page = new \Think\Page($count,20);
        $show = $page->show();
        $UserLog = M('UserLog')->alias('ul')->join('xueches_user u ON u.id = ul.uid')
            ->field('ul.*,u.truename,u.lastip,u.lasttime')
            ->limit($page->firstRow.','.$page->listRows)->where($where)->select();
        $this->assign('UserLog',$UserLog);
        $this->assign('firstRow',$page->firstRow);
        $this->assign('page',$show);
        $this->assign('count',$count);
        $this->assign('get',$_GET);
        $this->display();
    }
//数据导出
    public function push(){
        $res = $this->user_log_push($_GET);
        $this->success($res);
    }

    public function user_log_push($get){
        if ($get) {
            //搜索;
            if($get['stop_time']){
                $where ="ul.ntime  < '{$get['stop_time']}'";
            }else{
                foreach($get as $key=>$val){
                    if($key == 'ntime' && $val != ''){
                        $where.="ul.ntime >= '$val' and ";
                    }elseif($key == 'ntime1' && $val != ''){
                        $where.="ul.ntime <= '$val' and ";
                    }elseif($key == 'start_time' && $val != ''){
                        $where.="ul.ntime >= '$val' and ";
                    }elseif($key == 'username' && $val != ''){
                        $where.="u.truename like '%".trim($val)."%' and ";
                    }
                }$where = rtrim($where,'and ');
            }
        }

        $UserLog = M('UserLog')->alias('ul')->join('xueches_user u ON u.id = ul.uid')
            ->field('ul.*,u.truename,u.lastip,u.lasttime')->where($where)->select();
        if($get['stop_time']){
            M('UserLog')->where(array('ntime'=>array('lt',$get['stop_time'])))->delete();
        }
        $name='Excelfile';    //生成的Excel文件文件名
        $res = user_log_push($UserLog,$name);
        return $res;
    }

}
