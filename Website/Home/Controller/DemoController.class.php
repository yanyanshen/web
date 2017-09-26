<?php
namespace Home\Controller;
use Think\Controller;
class DemoController extends Controller {
    public function index(){
        $this->display();
    }

    public function add(){
        $lng1=I('post.lng');
        $lat1=I('post.lat');

        $aa=$this->distanceBetween($lat1,$lng1,30.868057,121.649725);
//        $aa=$this->distance($lng1,$lat1,121.649725,30.868057,false);
//        $aa=$this->distance($lng1,$lat1,121.649725,30.868057,false);
        dump($aa);

        $where['_string']='schools_lng !="" and schools_lat !=""';
        $info=M('schools')
            ->field('id,schools_name,schools_lng,schools_lat')
            ->where($where)
            ->select();
        foreach($info as $k=>$v){
            $info[$k]['length']=$this->getDistance($v['lng'],$v['lat'],$lng1,$lat1);
        }
        $this->success($aa,$lng1);
    }

/** @param float $fP1Lat 起点(纬度)
* @param float $fP1Lon 起点(经度)
* @param float $fP2Lat 终点(纬度)
* @param float $fP2Lon 终点(经度)*
* @return int*/

    function distanceBetween($fP1Lat, $fP1Lon, $fP2Lat, $fP2Lon){
        $fEARTH_RADIUS = 6378137;
        //角度换算成弧度
        $fRadLon1 = deg2rad($fP1Lon);
        $fRadLon2 = deg2rad($fP2Lon);
        $fRadLat1 = deg2rad($fP1Lat);
        $fRadLat2 = deg2rad($fP2Lat);
        //计算经纬度的差值
        $fD1 = abs($fRadLat1 - $fRadLat2);
        $fD2 = abs($fRadLon1 - $fRadLon2);
        //距离计算
        $fP = pow(sin($fD1/2), 2) + cos($fRadLat1) * cos($fRadLat2) * pow(sin($fD2/2), 2);
        return intval($fEARTH_RADIUS * 2 * asin(sqrt($fP)) + 0.5);
    }

}