<?php
namespace Mobile\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        //网站 进入 来源网站
        $word = search_word_from();
        session('mobile_order_source',$word['form']);
//        session('mobile_order_keyword',$word['keyword']);//还没有办法获得关键字
        session('k',null);
        if(!session('city')||!session('k')){
            $citysInfo = getCity();
            session('city',substr($citysInfo,0,9));
        }else{
            session('city',I('city'));
        }

        $city_name = session('city');
        $this->hot_list($city_name);
        $this->recommand_list($city_name);
        $this->week_list($city_name);
        $this->first_index($city_name);
        $this->slideshow();//轮播图展示
        $this->assign('http',C('HTTP'));
        $this->assign('empty',"<h style='text-align: center'>还有没有数据哦！！！</h>");
        session('mobile_return',U('Mobile/Index/index'));
        $this->display();
    }
    //获取首页热门驾校数据
    public function hot_list($city_name){
        $where['_string']='t.type_id=s.id and c.id=s.cityid';
        $where['t.hot']=1;
        $where['t.type']='jx';
        $where['c.cityname']=array('like',"%$city_name%");
        $info=M('School')->table('xueches_school s,xueches_trainclass t,xueches_citys c')
            ->field('s.id as school_id,s.nickname,s.connectteacher,s.score,s.address,s.picurl,s.picname,s.type,
                s.hot,s.allcount,s.class_num,s.account,t.id,t.name,t.officeprice,t.wholeprice,t.advanceprice,
                t.waittime,c.cityname')
            ->where($where)
            ->order('s.hot')
            ->select();
        $this->assign('hot_list',$info);
    }
    //首页驾校推荐
    public function recommand_list($city_name){
        $where['_string']='t.type_id=s.id and c.id=s.cityid';
        $where['t.recommand']=1;
        $where['t.type']='jx';
        $where['c.cityname']=array('like',"%$city_name%");
        $info=M('School')->table('xueches_school s,xueches_trainclass t,xueches_citys c')
            ->field('s.id as school_id,s.nickname,s.connectteacher,s.score,s.address,s.picurl,s.picname,s.type,
                s.recommand,s.allcount,s.class_num,s.account,t.id,t.name,t.officeprice,t.wholeprice,t.advanceprice,
                t.waittime,c.cityname')
            ->where($where)
            ->order('s.recommand')
            ->select();
        $this->assign('jx_list',$info);
    }

    //首页本周特价
    //本周驾校
    public function week_list($cityname){
        $where['_string']='t.type_id=s.id and c.id=s.cityid';
        $where['t.week']=1;
        $where['c.cityname']=array('like',"%$cityname%");
        $where['t.type']='jx';
        $info=M('School')->table('xueches_school s,xueches_trainclass t,xueches_citys c')
            ->field('s.id as school_id,s.nickname,s.connectteacher,s.score,s.address,s.picurl,s.picname,s.week,s.type,
                s.class_num,s.account,t.id,t.name,t.officeprice,t.wholeprice,t.advanceprice,t.waittime,c.cityname')
            ->where($where)
            ->order('s.week')
            ->select();
        $this->assign('week_list',$info);
        $this->assign('week_list1',$info);
    }

    //驾考咨询展示

    public function first_index($city_name){
        $where['_string']='s.flag=1 and s.cityid=c.id';
        $where['c.cityname']=array('like',"%$city_name%");
        $info=M('Consult')
            ->table('xueches_consult s,xueches_citys c')
            ->order('order1')
            ->field('s.id,s.order1,s.title,s.picurl,s.picname,s.flag,s.ntime,
                    s.update_people,s.touch_count,c.cityname,c.id as cityid')
            ->where($where)
            ->select();
        $this->assign('consult',$info);
    }

/*
 * User：沈艳艳
 * Date：2017/09/08
 * 首页轮播图
 */
    public function slideshow(){
        $where = 'flag = 1 and list_flag = 0';
        $info = D('Slideshow')->slideshow($where);
        $this->assign('info',$info);
    }
/*-------------------------------2017-10-20直学直考------------------------*/
    public function zxzk(){
        $this->assign('url',U('index'));
        $this->display();
    }
/*-------------------------------2017-10-20直学直考------------------------*/

}