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

    public function pull($city='上海',$county='杨浦',$address='陆家嘴',$latitude=31.232292,$longitude=121.52254){
        try {
            $cityid=M('citys')->field("id")->where("cityname like '%$city%'")->find()['id'];
            $countyid=M('countys')->field("id")->where("countyname like '%$county%' and cityid=$cityid")->find()['id'];
            $data['school']=M('school')
                ->field("id,nickname,score,allcount")
                ->where("nickname like '%$address%' and cityid=$cityid and verify=3")
                ->select();
            if($data['school']){

                foreach ($data['school'] as $k=>$v){
                    $userid=$v['id'];
                    $land[$k]=M('lands')->field('landmarkid')->where("type_id='$userid'")->find()['landmarkid'];
                    if($land[$k]){
                        $land[$k]=explode(',',rtrim($land[$k],','));
                        foreach($land[$k] as $kk=>$vv){
                            $data['school'][$k]['landmark'][$kk]=M('landmark')
                                ->field('id,landname,longitude,latitude')
                                ->where("id=$vv")->find();
                            if(empty($data['school'][$k]['landmark'][$kk])){
                                unset($data['school'][$k]['landmark'][$kk]);
                            }
                            shuffle($data['school'][$k]['landmark']);
                        }
                    }else{
                        $data['school'][$k]['landmark']=[];
                        continue;
                    }
                }$data['flag']=1;
                echo result(0,$data);
            }else{
                //           $lands=getAround($latitude,$longitude,10000);
                //         $minlat=$lands[0]; $maxlat=$lands[1];$minlng=$lands[2];$maxlng=$lands[3];
                $land=returnSquarePoint($longitude,$latitude,10);
                //	dump($land);
                $minlat=$land['left-bottom']['lat']; $maxlat=$land['left-top']['lat'];
                $minlng=$land['left-top']['lng'];$maxlng=$land['right-top']['lng'];
                $landd['land']=M('landmark')
                    ->field('id,longitude,latitude,landname')
                    ->where("cityid=$cityid and latitude>=$minlat and latitude<=$maxlat and longitude>=$minlng and longitude<=$maxlng")
                    ->select();
                foreach ($landd['land'] as $k=>$v){
                    $id=$v['id'];
                    $find=M('lands')->where("locate($id,landmarkid)")->select();
                    if($find){
                        $landd['land'][$k]['school']=M('lands l')
                            ->field("s.id,s.nickname,s.score,s.allcount")
                            ->join("xueches_school s on s.id=l.type_id and locate($id,l.landmarkid)")
                            ->order("rand()")
                            ->limit(3)
                            ->select();
                    }else{
                        unset($landd['land'][$k]);
                    }
                }
                $landd['land']=array_reverse($landd['land']);
                $landd['flag']=0;
                foreach($landd['land'] as $v){
                    $arr[] = $v['school'];
                }
                print_r($arr);

//                echo result(0,$landd);
            }
        } catch (Exception $e) {
            $info = zimg(1, "返回错误");
        }
        print_r($info) ;
    }



    public function select_table($table,$where,$page,$num,$field,$order=''){
        $info = M('school')->table("$table")
            ->field($field)
            ->page($page,$num)
            ->where($where)
            ->order($order)
            ->select();
        $info = array_reverse($info);
        return $info;
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