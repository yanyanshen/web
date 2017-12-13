<?php
namespace Mobile\Controller;
use Think\Controller;
class IndexController extends Controller
{
    public function index(){
//        $word = search_word_from();
//
//        if(!empty($word['keyword'])){
//            echo '关键字：'.$word['keyword'].' 来自：'.$word['from'];
//        }
//        print_r($word);
//        exit;
        //网站 进入 来源网站
        $word = search_word_from();
        session('mobile_order_source', $word['form']);
//        session('mobile_order_keyword',$word['keyword']);//还没有办法获得关键字
        session('k', null);
        if (!session('city')) {
            $citysInfo = getCity();
            session('city', substr($citysInfo, 0, 9));
        } else {
            session('city', I('city'));
        }

        $city_name = session('city');
        $this->hot_list($city_name);
        $this->recommand_list($city_name);
        $this->week_list($city_name);
        $this->first_index($city_name);
        $this->slideshow();//轮播图展示
        $this->assign('http', C('HTTP'));
        $this->assign('empty',"<h1 style='font-size: 20px;text-align: center;height: 30px;padding-top: 12px'>没有查到数据</h1>");
        session('mobile_return', U('Mobile/Index/index'));
        $this->display();
    }


    function search_word_from() {
        $referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
        if(strstr( $referer, 'baidu.com')){ //百度
            preg_match( "|baidu.+wo?r?d=([^\\&]*)|is", $referer, $tmp );
            $keyword = urldecode( $tmp[1] );
            $from = 'baidu';

            }elseif(strstr( $referer, 'google.com') or strstr( $referer, 'google.cn')){ //谷歌

            preg_match( "|google.+q=([^\\&]*)|is", $referer, $tmp );

            $keyword = urldecode( $tmp[1] );

            $from = 'google'; //www.jbxue.com

        }elseif(strstr( $referer, 'so.com')){ //搜索

            preg_match( "|so.+q=([^\\&]*)|is", $referer, $tmp );

            $keyword = urldecode( $tmp[1] );

            $from = '';

            }elseif(strstr( $referer, 'sogou.com')){ //搜狗

            preg_match( "|sogou.com.+query=([^\\&]*)|is", $referer, $tmp );

            $keyword = urldecode( $tmp[1] );

            $from = 'sogou';

            }elseif(strstr( $referer, 'soso.com')){ //搜搜

            preg_match( "|soso.com.+w=([^\\&]*)|is", $referer, $tmp );

            $keyword = urldecode( $tmp[1] );

            $from = 'soso';

            }else {

            $keyword ='';

            $from = '';

            }

        return array('keyword'=>$keyword,'from'=>$from);

    }
    //获取首页热门驾校数据
    public function hot_list($city_name){
        $where['_string']="c.id=s.cityid and s.show_forbid=1 and s.hot=1 and type ='jx' ";
        $where['c.cityname']=array('like',"%$city_name%");
        $info=M('School')->table('xueches_school s,xueches_citys c')
            ->field('s.id as school_id,s.nickname,s.picurl,s.picname,s.type,s.hot,c.cityname,s.minprice,s.highprice,s.student_num')
            ->where($where)->order('s.hot')->select();
        $this->assign('hot_list',$info);
    }
    //首页驾校推荐
    public function recommand_list($city_name){
        $where['_string']="c.id=s.cityid and s.show_forbid=1 and s.recommand=1 and s.type='jx' ";
        $where['c.cityname']=array('like',"%$city_name%");
        $info=M('School')->table('xueches_school s,xueches_citys c')
            ->field('s.id as school_id,s.nickname,s.picurl,s.picname,s.type,s.recommand,c.cityname,s.minprice,s.highprice,s.student_num')
            ->where($where)->order('s.recommand')->select();
        $this->assign('jx_list',$info);
    }

    //首页本周特价
    //本周驾校
    public function week_list($cityname){
        $where['_string']="c.id=s.cityid and s.show_forbid=1 and s.week=1 and type = 'jx' ";
        $where['c.cityname']=array('like',"%$cityname%");
        $info=M('School')->table('xueches_school s,xueches_citys c')
            ->field('s.id as school_id,s.nickname,s.picurl,s.picname,s.week,s.type,c.cityname,s.minprice,s.highprice,s.student_num')
            ->where($where)->order('s.week')->select();
        $this->assign('week_list',$info);
        $this->assign('week_list1',$info);
    }

    //驾考咨询展示

    public function first_index($city_name){
        $where['_string']='s.flag=1 and s.cityid=c.id';
        $where['c.cityname']=array('like',"%$city_name%");
        $info=M('Consult')->table('xueches_consult s,xueches_citys c')->order('order1')
            ->field('s.id,s.title,s.picurl,s.ntime,s.touch_count,c.cityname,c.id as cityid')
            ->where($where)->select();
        foreach($info as $k=>$v){
            if(strlen($v['touch_count'])>=4){
                $info[$k]['touch_count']=sprintf("%.4f", $v['touch_count']/10000).'万';
            }
        }
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