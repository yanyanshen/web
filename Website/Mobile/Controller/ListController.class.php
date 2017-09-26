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


    public function pull(){
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
            if(I('k')||I('countyid')||I('jztype')){
                session('page',null);
                session('order',null);
                session('table',null);
                session('field',null);
                session('jztype',null);
                session('r',null);
                session('p',null);
                session('e',null);
                session('all',null);
                session('k',I('k'));
                if(I('countyid')){
                    $countyname = M('countys')->where(array('id'=>I('countyid')))->getField('countyname');
                    session('k',$countyname);
                }elseif(I('jztype')){
                    session('jztype',I('jztype'));
                }
            }
            if(session('k')||session('jztype')){
                $field='DISTINCT s.id,tc.wholeprice,s.evalutioncount,s.nickname,s.picurl,s.picname,s.recommand,s.allcount,s.type';
                $order = '';
                $k = session('k');
                $table = 'xueches_school s,xueches_trainclass tc,xueches_type type';
                $where = "s.id=tc.type_id and type.id=tc.jztype and s.cityid = $cityid and s.nickname like '%$k%'";
                if(session('jztype')){
                    $jztype = session('jztype');
                    M('type')->where(array('id'=>$jztype))->getField('jztype');
                    session('k',M('type')->where(array('id'=>$jztype))->getField('jztype'));
                    $where = "s.id=tc.type_id and type.id=tc.jztype and s.cityid = $cityid and tc.jztype=$jztype";
                }
            }

            /*推荐*/
            if(I('r')){
                session('all',null);
                session('p',null);
                session('e',null);
                session('r','recommand');
                $order = 's.recommand desc';
            }
            if(I('all')){
                session('all','allcount');
                session('r',null);
                session('p',null);
                session('e',null);
                $order = 's.allcount desc';
            }
            if(I('e')){
                session('all',null);
                session('p',null);
                session('r',null);
                session('e','evalutioncount');
                $order = 's.evalutioncount desc';
            }
            if(I('p')){
                session('all',null);
                session('r',null);
                session('e',null);
                session('p','wholeprice');
                $order = 'tc.wholeprice';
            }

            if(!session('k')){
                $table = 'xueches_school s,xueches_trainclass tc,xueches_type type';
                $field='DISTINCT s.id,tc.wholeprice,s.evalutioncount,s.nickname,s.picurl,s.picname,s.recommand,s.allcount,s.type';
                $where = "s.id=tc.type_id and type.id=tc.jztype and s.cityid = $cityid";
            }

            $info = $this->select_table($table,$where,$page,7,$field,$order);

            if(IS_AJAX){//判断ajax请求
                $page = $_POST['page']?$_POST['page']:1;
                $num = 7;
                session('page', $page);
                $info = $this->select_table(session('table'),session('where'),session('page'),$num,$field,session('order'));
                $count = count($info);

                if ($count < $num) {//判断是否到尾�?
                    $info[]['id'] = 0;//到尾页返�?
                }
                echo json_encode($info);
                exit;//中断后面的display()
            }
            if(empty($info)){
                $address = session('city').$k;
                $coordinate = addressToCoordinate($address);
                $lat = $coordinate['result']['location']['lat'];
                $lng = $coordinate['result']['location']['lng'];
                if($coordinate){
                    $table = 'xueches_school s,xueches_landsjuli juli,xueches_trainclass tc,xueches_landmark l';
                    $where = "juli.sid=s.id and juli.landmarkid=l.id  and tc.type_id=s.id  and s.cityid = $cityid";
                    session('jl',1);
                    if(session(jl)){
                        $order = 'jl asc';
                    }elseif(session('p')){
                        $order = 'tc.wholeprice';
                    }
                    //经纬度计算距离公
                    $field='DISTINCT s.id,tc.wholeprice,s.evalutioncount,s.nickname,s.picurl,s.picname,s.recommand,l.latitude,l.longitude,s.allcount,s.type,
                    (2 * 6378.137* ASIN(SQRT(POW(SIN(3.1415926535898*('.$lat.'-Latitude)/360),2)+COS(3.1415926535898*'.$lng.'/180)* COS(Latitude * 3.1415926535898/180)*POW(SIN(3.1415926535898*('.$lng.'-Longitude)/360),2)))) as jl ';
                    $info = $this->select_table($table,$where,$page,7,$field,$order);
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
        $this->assign('empty', "<h1 style='height: 30px;background-color: #ffffff;padding-top: 10px;text-align: center;font-size: 15px'>暂无数据</h1>");
        $this->display();
    }


    public function select_table($table,$where,$page,$num,$field,$order=''){
            $info = M('school')->table("$table")
                ->field($field)
                ->page($page,$num)
                ->where($where)
                ->order($order)
                ->select();
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