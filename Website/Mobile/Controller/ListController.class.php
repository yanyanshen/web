<?php
namespace Mobile\Controller;
use Think\Controller;
class ListController extends Controller{
//筛选内
    public function select(){
        $cityid=M('citys')->where(array('cityname'=>session('city')))->getField('id');
        $arr=array();
        $arr['countys'] = M('countys')->where(array('cityid'=>$cityid))->select();
        $arr['xc']=M('type')->where(array('type'=>1))->select();
        foreach($arr['xc'] as $k=>$v){
              preg_match('/[a-zA-Z0-9]+/',$v['jztype'],$arr['xc'][$k]['jztype']);
        }
        $arr['kc']=M('type')->where('type=2 or type=3')->select();

        foreach($arr['kc'] as $k=>$v){
            preg_match('/[a-zA-Z0-9]+/',$v['jztype'],$arr['kc'][$k]['jztype']);
        }
        $this->success($arr);
    }

//    public function pull(){
//        if (I('city')) {
//            session('city', I('city'));
//        }
//        $city = session('city');
//        if(I('k')){
//            session('k',I('k'));
//        }
//        $address = session('k');
//        $address = '国顺路';
//        $cityid=M('citys')->field("id")->where("cityname like '%$city%'")->find()['id'];
//        $jwd=curlGetWeb($city, $address);
//        $land=getAround($jwd['lat'],$jwd['lng'],10000);
////        $minlat=$land[0]; $maxlat=$land[1];$minlng=$land[2];$maxlng=$land[3];
//        $info= getSchoolList(0,$cityid,$jwd['lat'],$jwd['lng']);
//    print_r($info);
//        exit;
//        try {
//            $cityid=M('citys')->field("id")->where("cityname like '%$city%'")->find()['id'];
//            $countyid=M('countys')->field("id")->where("countyname like '%杨浦区%' and cityid=$cityid")->find()['id'];
//            $count['school']=M('school')->field("id,nickname,score,allcount")->where("nickname like '%$address%' and cityid=$cityid")->select();
//            if(empty($count['school'])){
//                $jwd=curlGetWeb($city, $address);
//                $land=getAround($jwd['lat'],$jwd['lng'],10000);
//                $minlat=$land[0]; $maxlat=$land[1];$minlng=$land[2];$maxlng=$land[3];
//                $landmark['land']=M("landmark")->field("id,landname,longitude,latitude")
//                    ->where("latitude>=$minlat and latitude<=$maxlat and longitude>=$minlng and longitude<=$maxlng")
//                    ->Distinct(true)
//                    ->order("rand()")
//                    ->limit(33)->select();
//                foreach($landmark['land'] as $k=>$v){
//                    $id=$v['id'];
//                    $data[$k]=M('school s')
//                        ->field("s.nickname,s.id,s.score,s.allcount")
//                        ->Distinct(true)
//                        ->join("xueches_landsjuli l on l.sid=s.id and l.landmarkid=$id")
//                        ->order("rand()")
//                        ->limit(3)->select();
//                    if(empty($data[$k]) ||$data[$k]==null){
//                        $landmark['land'][$k]['school']=[];
//                    }else{
//                        $landmark['land'][$k]['school']=$data[$k];
//                    }
//                }
//                $coun['flag']=0;
//            }else{
//                $coun['flag']=1;
//                foreach($count['school'] as $k=>$v){
//                    $uid=$v['id'];
//                    $count['school'][$k]['landmark']=M("landsjuli s")->field("l.id,l.landname,l.longitude,l.latitude")
//                        ->join("xueches_landmark l on l.id=s.landmarkid and s.sid='$uid'")
//                        ->order("rand()")
//                        ->limit(50)->select();
//                }
//                echo  result(0, array_merge($count,$coun));
//                return;
//            }
//            $info=result(0, array_merge($landmark,$coun));
//        } catch (Exception $e) {
//            $info = zimg(1, "返回错误");
//        }
//        echo $info;
//        $this->assign('http', C('HTTP'));
//        $this->assign('empty', "<h1 style='height: 30px;background-color: #ffffff;padding-top: 10px;text-align: center;font-size: 15px'>暂无数据</h1>");
//        $this->display();
//    }

    public function pull(){
        session('mobile_return',U('Mobile/List/pull'));
        $this->slideshow();
        if (I('city')) {
            session('city', I('city'));
        }
        $city_name = session('city');
        $cityid = M('citys')->where(array('cityname'=>array('like',"%$city_name%")))->getField('id');
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
                $field='s.id,s.minprice,s.evalutioncount,s.nickname,s.picurl,s.picname,s.recommand,s.student_num,s.type,s.verify';
                $k = session('k');
                $table = 'xueches_school s';
                $where = "s.show_forbid=1 and s.cityid = $cityid and (s.nickname like '%$k%' or s.jtype like '%$k%')  and s.verify=3";
            }else{
                $table = 'xueches_school s';
                $field='s.id,s.minprice,s.evalutioncount,s.nickname,s.picurl,s.picname,s.recommand,s.student_num,s.type,s.minprice';
                $where = "s.show_forbid=1 and s.cityid = $cityid  and s.verify=3 and s.type='jx'";
            }

            /*推荐*/
            if(I('r')){session('r',1);}
            if(session('all')){
                session('all',null);
                session('p',null);
                session('e',null);
                $order = 's.recommand desc';
            }
            if(I('all')){session('all',1);}
            if(session('all')){
                session('r',null);
                session('p',null);
                session('e',null);
                $order = 's.student_num desc';
            }
            if(I('e')){session('e',1);}
            if(session('e')){
                session('all',null);
                session('p',null);
                session('r',null);
                $order = 's.evalutioncount desc';
            }
            if(I('p')){session('p',1);}
            if(session('p')){
                session('all',null);
                session('r',null);
                session('e',null);
                $order = 's.minprice';
            }
            $info = $this->select_table($table,$where,$page,20,$field,$order);

            if(IS_AJAX){//判断ajax请求
                $page = $_POST['page']?$_POST['page']:1;
                $num = 20;
                $info = $this->select_table(session('table'),session('where'),$page,$num,$field,session('order'));
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
                    $field="s.id,s.minprice,s.evalutioncount,s.nickname,s.picurl,s.picname,s.recommand,l.latitude,
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
                    ) AS   jl";

                    session('juli',1);
                    if(session('juli')){
                        $order = 'jl,rand()';
                    }elseif(session('p')){
                        $order = 's.minprice';
                    }
                    $info = $this->select_table($table,$where,$page,20,$field,$order);
                }else{
                    $info = array();
                }
            }
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
            ->where($where)->order($order)
            ->select();
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