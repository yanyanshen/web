<?php
namespace Mobile\Controller;
use Think\Controller;
class ListController extends Controller{
    public function pull(){
        $url = $_SERVER['REQUEST_URI'];
        preg_match ("/(\/jiaxiao\/list)/",$url,$matches,PREG_OFFSET_CAPTURE);
        $city = substr($url,0,$matches[0][1]);
        $city_pinyin = substr($city,1);
        $city_info = M('citys')->field('cityname,id')->where(array('pinyin'=>$city_pinyin))->find();
        session('mobile_return',C('HTTP').$_SERVER['REQUEST_URI']);
        $this->assign('url',U($city_pinyin.'/jiaxiao/list/'));
        session('city', $city_info['cityname']);
        $this->slideshow();
        $city_name = session('city');
        $cityid = M('citys')->where(array('cityname'=>array('like',"%$city_name%")))->getField('id');
        /*推荐*/
        if(I('r')){session('r',1);}
        if(session('r')){
            session('juli',null);
            session('all',null);
            session('p',null);
            session('e',null);
            $order = 's.recommand desc';
        }
        if(I('all')){session('all',1);}
        if(session('all')){
            session('juli',null);
            session('r',null);
            session('p',null);
            session('e',null);
            $order = 's.student_num desc';
        }
        if(I('e')){session('e',1);}
        if(session('e')){
            session('juli',null);
            session('all',null);
            session('p',null);
            session('r',null);
            $order = 's.evalutioncount desc';
        }
        if(I('p')){session('p',1);}
        if(session('p')){
            session('juli',null);
            session('all',null);
            session('r',null);
            session('e',null);
            $order = 's.minprice';
        }
        if(!$cityid){
            $info = array();
        }else{
            $page = $_POST['page']?$_POST['page']:1;
            if(I('k')){
                session('page',null);
                session('order',null);
                session('table',null);
                session('field',null);
                session('r',null);
                session('p',null);
                session('e',null);
                session('all',null);
                session('k',I('k'));
            }
            if(session('k')){
                $field='s.id,s.pinyin,s.cityid,s.minprice,s.highprice,s.evalutioncount,s.nickname,s.picurl,s.picname,s.recommand,s.student_num,s.type,s.verify';
                $k = session('k');
                $table = 'xueches_school s';
                $where = "s.show_forbid=1 and s.cityid = $cityid and s.nickname like '%$k%'  and s.verify=3";
            }else{
                $table = 'xueches_school s';
                $field='s.id,s.pinyin,s.cityid,s.minprice,s.evalutioncount,s.nickname,s.picurl,s.picname,s.recommand,s.student_num,s.type,s.highprice';
                $where = "s.show_forbid=1 and s.cityid = $cityid  and s.verify=3 and s.type='jx'";
            }
            $info = $this->select_table($table,$where,$page,60,$field,$order);
            if(IS_AJAX){//判断ajax请求
                $page = $_POST['page']?$_POST['page']:1;
                $num = 60;
                $info = $this->select_table(session('table'),session('where'),$page,$num,session('field'),session('order'));
                $count = count($info);

                if ($count <= 0) {//判断是否到尾?
                    $info[]['id'] = 0;//到尾页返?
                }
                echo json_encode($info);
                exit;//中断后面的display()
            }
            if(empty($info)){
                $address = session('city');
                $coordinate = curlGetWeb($address,$k);
                $lat = $coordinate['lat'];
                $lng = $coordinate['lng'];
                if($coordinate){
                    $table = 'xueches_school s,xueches_lands juli,xueches_landmark l';
                    $where = "l.id in (juli.landmarkid) and juli.type_id = s.id and s.show_forbid=1  and s.cityid = $cityid  and s.verify=3 and s.type='jx' ";
                    //经纬度计算距离公
                    $field="s.id,s.pinyin,s.cityid,s.minprice,s.highprice,s.evalutioncount,s.nickname,s.picurl,s.picname,s.recommand,l.latitude,
                    l.longitude,s.student_num,s.type, ROUND(
                        6378.138 * 2 * ASIN(
                            SQRT(
                                POW(
                                    SIN(
                                        (31.2322920000 * PI() / 180 - l.latitude * PI() / 180) / 2),2
                                ) + COS(31.2322920000 * PI() / 180) * COS(l.latitude * PI() / 180) * POW(
                                    SIN(
                                    (121.522540000 * PI() / 180 - l.longitude * PI() / 180) / 2),2))
                        ) * 1000
                    ) AS juli";

                    session('juli',1);
                    if(session('juli')){
                        $order = 'rand(),juli';
                    }
                    $info = $this->select_table($table,$where,$page,60,$field,$order);
                }else{
                    $info = array();
                }
            }
        }
        if(count($info) == 1){
            session('k',null);
            $this->redirect($info[0]['url']);
        }
        $this->assign('info',$info);
        session('where',$where);
        session('table',$table);
        session('field',$field);
        $this->assign('http', C('HTTP'));
        $this->assign('empty',"<h1 style='font-size: 20px;text-align: center;height: 30px;padding-top: 12px'>没有查到数据</h1>");
        $this->display();
    }


    public function select_table($table,$where,$page,$num,$field,$order=''){
        $info = M('school')->table("$table")
            ->field($field)->page($page,$num)
            ->where($where)->order($order)->select();
        foreach($info as $k=>$v){
            $city_pin = M('citys')->where(array('id'=>$v['cityid']))->getField('pinyin');
            $info[$k]['url'] = "/$city_pin/jiaxiao/list/{$v['pinyin']}/";
        }
        $this->assoc_unique($info,'id');
        $info = array_reverse($info);
        return $info;
    }

    public function assoc_unique(&$arr, $key) {
        $rAr=array();
        for($i=0;$i<count($arr);$i++)
        {
            if(!isset($rAr[$arr[$i][$key]]))
            {
                $rAr[$arr[$i][$key]]=$arr[$i];
            }
        }
        $arr=array_values($rAr);
    }
    /*
     * User：沈艳艳
     * Date：2017/09/08
     * 首页轮播图
     */
    public function slideshow(){
        $where = 'flag = 1 and list_flag = 1';
        $info = D('Slideshow')->slideshow($where);
        $this->assign('http',C('HTTP'));
        $this->assign('slideshow',$info);
    }
}