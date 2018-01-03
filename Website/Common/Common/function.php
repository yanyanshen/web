<?php
header('Content-type:text/html;charset=utf-8');
import('Org.PHPExcel.PHPExcel');
import('Think.Image');
import('Think.Upload');
function search_word_from() {
    $referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
    if(strstr( $referer, 'baidu.com')){ //百度
        preg_match( "|baidu.+wo?r?d=([^\\&]*)|is", $referer, $tmp );
        $keyword = urldecode( $tmp[1] );
        $from = '百度'; //
    }elseif(strstr( $referer, 'google.com') or strstr( $referer, 'google.cn')){ //谷歌
        preg_match( "|google.+q=([^\\&]*)|is", $referer, $tmp );
        $keyword = urldecode( $tmp[1] );
        $from = '谷歌';
    }elseif(strstr( $referer, 'so.com')){ //360搜索
        preg_match( "|so.+q=([^\\&]*)|is", $referer, $tmp );
        $keyword = urldecode( $tmp[1] );
        $from = '360搜索';
    }elseif(strstr( $referer, 'sogou.com')){ //搜狗
        preg_match( "|sogou.com.+query=([^\\&]*)|is", $referer, $tmp );
        $keyword = urldecode( $tmp[1] );
        $from = '搜狗';
    }elseif(strstr( $referer, 'soso.com')){ //搜搜
        preg_match( "|soso.com.+w=([^\\&]*)|is", $referer, $tmp );
        $keyword = urldecode( $tmp[1] );
        $from = '搜搜';
    }else {
        $keyword ='';
        $from = '';
    }
    return array('keyword'=>$keyword,'from'=>$from);
}
/*
 * 获取 IP  地理位置
 * 新浪 IP接口  可直接获取  但是不如淘宝的信息全面
 * 淘宝IP接口 需要输入地址
 * @Return: array
 */
function getCity($ip = ''){
    $ip = get_client_ip(0, true); //获取客户端IP地址（TP方法）
    $IpIpLocation = new \Org\Net\IpLocation('data.dat'); // 实例化类 参数表示IP地址库文件
    $area = $IpIpLocation->getlocation($ip); // 获取某个IP地址所在的位置
    $str = $area['country']; //合并位置
    $str = iconv("GB2312", "UTF-8", $str); //因为最新版为GBK 转为UTF8
    return trim($str);
}
/*获得ip地址 沈艳艳*/
function getIp() {
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else
        if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else
            if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
                $ip = getenv("REMOTE_ADDR");
            else
                if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
                    $ip = $_SERVER['REMOTE_ADDR'];
                else
                    $ip = "unknown";
    return ($ip);
}


/**
 * 读取excel的数据
 * @param  string $filename Excel表的位置
 * @param  string $encode 编码
 * @return $excelData       数组
 */
function ImportExcel($filename,$encode='utf-8'){

    $objReader = PHPExcel_IOFactory::createReader('Excel5');

    $objReader->setReadDataOnly(true);

    $objPHPExcel = $objReader->load($filename);

    $objWorksheet = $objPHPExcel->getActiveSheet();

    $highestRow = $objWorksheet->getHighestRow();
    $highestColumn = $objWorksheet->getHighestColumn();
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    $excelData = array();
    for ($row = 1; $row <= $highestRow; $row++) {
        for ($col = 0; $col < $highestColumnIndex; $col++) {
            $excelData[$row][] =(string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
        }
    }
    return $excelData;
}
/**
 * 导出excel的数据
 * @param string $data 数据
 * @param  string $name  导出类型
 * @return $excelData       数组
 */
function push($data,$name='Excel'){
    error_reporting(E_ALL);
    date_default_timezone_set('Europe/London');
    $objPHPExcel = new PHPExcel();
/*以下是一些设置 ，什么作者  标题啊之类的*/
    $objPHPExcel->getProperties()->setCreator("转弯的阳光")
        ->setLastModifiedBy("转弯的阳光")
        ->setTitle("数据EXCEL导出")
        ->setSubject("数据EXCEL导出")
        ->setDescription("备份数据")
        ->setKeywords("excel")
        ->setCategory("result file");
/*以下就是对处理Excel里的数据， 横着取数据，主要是这一步，其他基本都不要改*/
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'id')
        ->setCellValue('B1', '订单编号')
        ->setCellValue('C1', '创建时间')
        ->setCellValue('D1', '订单数量')
        ->setCellValue('E1', '学员姓名')
        ->setCellValue('F1', '性别')
        ->setCellValue('G1', '电话')
        ->setCellValue('H1', '应付金额')
        ->setCellValue('I1', '实付金额')
        ->setCellValue('J1', '支付状态')
        ->setCellValue('K1', '订单状态')
        ->setCellValue('L1', '驾校')
        ->setCellValue('M1', '基地')
        ->setCellValue('N1', '课程')
        ->setCellValue('o1', '买家邮箱')
        ->setCellValue('P1', '回访时间')
        ->setCellValue('Q1', '结算时间')
        ->setCellValue('R1', '退费时间')
        ->setCellValue('S1', '退费金额')
        ->setCellValue('T1', '支付时间')
        ->setCellValue('U1', '学员地址')
        ->setCellValue('V1', '支付方式')
        ->setCellValue('W1', '订单类型')
        ->setCellValue('X1', '订单来源')
        ->setCellValue('Y1', '取消时间')
        ->setCellValue('Z1', '跟单客服')
        ->setCellValue('AA1', '客服备注')
        ->setCellValue('AB1', '最新更新人');

    foreach($data as $k => $v){
        $num=$k+2;
        if($v['sex'] == 0){
            $v['sex'] = '男';
        }else{
            $v['sex'] = '女';
        }
        //支付状态
        if($v['status'] == 1){
            $v['status'] = '未支付待处理';
        }elseif($v['status'] == 2){
            $v['status'] = '已付款待结算';
        }elseif($v['status'] == 3){
            $v['status'] = '已完成';
        }elseif($v['status'] == 4){
            $v['status'] = '已评价';
        }elseif($v['status'] == 5){
            $v['status'] = '已取消';
        }elseif($v['status'] == 6){
            $v['status'] = '已退款';
        }
        //订单状态
        if($v['order_status'] == 1){
            $v['order_status'] = '待处理';
        }elseif($v['order_status'] == 2){
            $v['order_status'] = '待回访';
        }elseif($v['order_status'] == 3){
            $v['order_status'] = '待结算';
        }elseif($v['order_status'] == 4){
            $v['order_status'] = '已完成';
        }elseif($v['order_status'] == 5){
            $v['order_status'] = '已取消';
        }elseif($v['order_status'] == 6){
            $v['order_status'] = '已退款';
        }
        //支付方式
        if($v['pay_type'] == 0){
            $v['pay_type'] = '未支付';
        }elseif($v['pay_type'] == 1){
            $v['pay_type'] = '支付宝';
        }elseif($v['pay_type'] == 2){
            $v['pay_type'] = '微信';
        }elseif($v['pay_type'] == 3){
            $v['pay_type'] = '门店';
        }elseif($v['pay_type'] == 4){
            $v['pay_type'] = '快递';
        }elseif($v['pay_type'] == 5){
            $v['pay_type'] = '驾校';
        }
        //订单类型
        if($v['order_type'] == 1){
            $v['order_type'] = '学车需求';
        }elseif($v['order_type'] == 2){
            $v['order_type'] = '在线订单';
        }elseif($v['order_type'] == 3){
            $v['order_type'] = '人工订单';
        }elseif($v['order_type'] == 4){
            $v['order_type'] = '其他类型';
        }


        $objPHPExcel->setActiveSheetIndex(0)
//Excel的第A列，uid是你查出数组的键值，下面以此类推
            ->setCellValue('A'.$num, $v['id'])
            ->setCellValue('B'.$num, $v['ordcode'])
            ->setCellValue('C'.$num, $v['create_time'])
            ->setCellValue('D'.$num, $v['num'])
            ->setCellValue('E'.$num, $v['name'])
            ->setCellValue('F'.$num, $v['sex'])
            ->setCellValue('G'.$num, $v['tel'])
            ->setCellValue('H'.$num, $v['price'])
            ->setCellValue('I'.$num, $v['total_fee'])
            ->setCellValue('J'.$num, $v['status'])
            ->setCellValue('K'.$num, $v['order_status'])
            ->setCellValue('L'.$num, $v['s_nickname'])
            ->setCellValue('M'.$num, $v['trname'])
            ->setCellValue('N'.$num, $v['class_name'])
            ->setCellValue('O'.$num, $v['buyer_email'])
            ->setCellValue('P'.$num,$v['return_time'])
            ->setCellValue('Q'.$num,$v['end_time'])
            ->setCellValue('R'.$num,$v['return_fee'])
            ->setCellValue('S'.$num,$v['return_money'])
            ->setCellValue('T'.$num,$v['notify_time'])
            ->setCellValue('U'.$num,$v['address'])
            ->setCellValue('V'.$num,$v['pay_type'])
            ->setCellValue('W'.$num,$v['order_type'])
            ->setCellValue('X'.$num,$v['cancel_reason'])
            ->setCellValue('Y'.$num,$v['cancel_time'])
            ->setCellValue('Z'.$num,$v['customer'])
            ->setCellValue('AA'.$num,$v['customer_inform'])
            ->setCellValue('AB'.$num,$v['lastupdate']);
    }
    $objPHPExcel->getActiveSheet()->setTitle('id');
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$name.'.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
}
function push_data($data,$name='Excel'){
    error_reporting(E_ALL);
    date_default_timezone_set('Europe/London');
    $objPHPExcel = new PHPExcel();
    /*以下就是对处理Excel里的数据， 横着取数据，主要是这一步，其他基本都不要改*/
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'id')
        ->setCellValue('B1', '管理员')
        ->setCellValue('C1', '创建时间')
        ->setCellValue('D1', '登录ip')
        ->setCellValue('E1', '操作');
    foreach($data as $k => $v){
        $num=$k+2;
        $objPHPExcel->setActiveSheetIndex(0)
//Excel的第A列，uid是你查出数组的键值，下面以此类推
            ->setCellValue('A'.$num, $v['id'])
            ->setCellValue('B'.$num, $v['username'])
            ->setCellValue('C'.$num, date('Y-m-d H:i:s',$v['ntime']))
            ->setCellValue('D'.$num, $v['lastip'])
            ->setCellValue('E'.$num, $v['done']);
    }
    $objPHPExcel->getActiveSheet()->setTitle('管理员操作日志');
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$name.'.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
}
function push_data1($data,$name='Excel'){
    error_reporting(E_ALL);
    date_default_timezone_set('Europe/London');
    $objPHPExcel = new PHPExcel();
    /*以下就是对处理Excel里的数据， 横着取数据，主要是这一步，其他基本都不要改*/
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'id')
        ->setCellValue('B1', '订单编号')
        ->setCellValue('C1', '管理员')
        ->setCellValue('D1', '创建时间')
        ->setCellValue('E1', '登录ip')
        ->setCellValue('F1', '操作');
    foreach($data as $k => $v){
        $num=$k+2;
        $objPHPExcel->setActiveSheetIndex(0)
//Excel的第A列，uid是你查出数组的键值，下面以此类推
            ->setCellValue('A'.$num, $v['id'])
            ->setCellValue('B'.$num, $v['ordcode'])
            ->setCellValue('C'.$num, $v['username'])
            ->setCellValue('D'.$num, date('Y-m-d H:i:s',$v['ntime']))
            ->setCellValue('E'.$num, $v['lastip'])
            ->setCellValue('F'.$num, $v['done']);
    }
    $objPHPExcel->getActiveSheet()->setTitle('管理员操作日志');
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$name.'.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
}
function user_log_push($data,$name='Excel'){
    error_reporting(E_ALL);
    date_default_timezone_set('Europe/London');
    $objPHPExcel = new PHPExcel();
    /*以下就是对处理Excel里的数据， 横着取数据，主要是这一步，其他基本都不要改*/
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'id')
        ->setCellValue('B1', '用户名')
        ->setCellValue('C1', '操作')
        ->setCellValue('D1', 'url')
        ->setCellValue('E1', '添加时间')
        ->setCellValue('F1', '最后登陆时间')
        ->setCellValue('G1', '登录ip');
    foreach($data as $k => $v){
        $num=$k+2;
        $objPHPExcel->setActiveSheetIndex(0)
//Excel的第A列，uid是你查出数组的键值，下面以此类推
            ->setCellValue('A'.$num, $v['id'])
            ->setCellValue('B'.$num, $v['truename'])
            ->setCellValue('C'.$num, $v['done'])
            ->setCellValue('D'.$num, $v['url'])
            ->setCellValue('E'.$num, $v['ntime'])
            ->setCellValue('F'.$num, date('Y-m-d H:i:s',$v['lasttime']))
            ->setCellValue('G'.$num, $v['lastip']);
    }
    $objPHPExcel->getActiveSheet()->setTitle('用户操作日志');
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$name.'.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
}
//导出试题列表
function push_exam($data,$name='Excel'){
    error_reporting(E_ALL);
    date_default_timezone_set('Europe/London');
    $objPHPExcel = new PHPExcel();
    /*以下就是对处理Excel里的数据， 横着取数据，主要是这一步，其他基本都不要改*/
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'id')
        ->setCellValue('B1', 'question')
        ->setCellValue('C1', 'A选项')
        ->setCellValue('D1', 'B选型')
        ->setCellValue('E1', 'C选项')
        ->setCellValue('F1', 'D选项')
        ->setCellValue('G1', '答案')
        ->setCellValue('H1', '解析')
        ->setCellValue('I1', '试题类型(单选0;多选1;判断2)')
        ->setCellValue('J1', '图片路径(无图片是0)')
        ->setCellValue('K1', '章节(科一:小客车1-4;城市5;客车、轮式6;货车7)(科四:1-7)')
        ->setCellValue('L1', '城市id(上海1;北京2;浙江3;山东4;山西5;安徽6;黑龙江7;四川8)')
        ->setCellValue('M1', '驾照类型(科一:城市题库0;小客车1;客车2;货车3;轮式4)(科四:0)')
        ->setCellValue('N1', '科目类型(科一1;科四2)');
    foreach($data as $k => $v){
        $num=$k+2;
        $objPHPExcel->setActiveSheetIndex(0)
//Excel的第A列，uid是你查出数组的键值，下面以此类推
            ->setCellValue('A'.$num, $v['id'])
            ->setCellValue('B'.$num, $v['question'])
            ->setCellValue('C'.$num, $v['s1'])
            ->setCellValue('D'.$num, $v['s2'])
            ->setCellValue('E'.$num, $v['s3'])
            ->setCellValue('F'.$num, $v['s4'])
            ->setCellValue('G'.$num, $v['answer'])
            ->setCellValue('H'.$num, $v['analysis'])
            ->setCellValue('I'.$num, $v['ifmul'])
            ->setCellValue('J'.$num, $v['image'])
            ->setCellValue('K'.$num, $v['chapter'])
            ->setCellValue('L'.$num, $v['cityid'])
            ->setCellValue('M'.$num, $v['type'])
            ->setCellValue('N'.$num, $v['subject']);
    }
    $objPHPExcel->getActiveSheet()->setTitle('用户操作日志');
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$name.'.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
}
///在线交易订单支付处理函数
//函数功能：根据支付接口传回的数据判断该订单是否已经支付成功；
//返回值：如果订单已经成功支付，返回true，否则返回false；

function checkorderstatus($where){
    $order=M('order');
    $ordstatus=$order->where($where)->getField('status');
    if($ordstatus == 1){
        return false;
    }else{
        return true;
    }
}
//处理订单函数
//更新订单状态，写入订单支付后返回的数据
function orderhandle($parameter){
    $parameter['status'] = 2;
    $item_order=M('order');
    //有的订单 是有相同的订单号  所以不能给这些订单的实际付款 是总的付款额
    $item_order ->where("ordcode='{$parameter['out_trade_no']}'")->save($parameter);
}

/*-----------------------------------
 2013.8.13更正
 下面这个函数，其实不需要，大家可以把他删掉，
 具体看我下面的修正补充部分的说明
 ------------------------------------*/
//获取一个随机且唯一的订单号；
function getordcode(){
    $Ord=M('Order');
    $ordcode = date('Ymd').substr(md5(uniqid(microtime(true))), 0, 14);
    $oldcode = $Ord->where("ordcode='".$ordcode."'")->getField('ordcode');
    if($oldcode){
        getordcode();
    }else{
        return $ordcode;
    }
}


//图片上传类封装
function UploadPic($table,$file_name,$id){
    $upload = new Think\Upload();
    $upload->maxSize = 3145728;
    $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
    $upload->rootPath = "./Uploads/$file_name/";
    if (!file_exists($upload->rootPath)) {
        mkdir($upload->rootPath);
    }
    $info=$upload->upload();
    if(!$info){
        $res=$upload->getError();
    }else{
        $data['picurl']=$info['image']['savepath'];
        $data['picname']=$info['image']['savename'];
        $data['ntime']=time();
        $res=M($table)->field('picurl,picname,ntime')->where(array('id'=>$id))->save($data);
    }
    return $res;
}

function editorPic($table,$file_name,$id){
    //更新图片信息
    $upload = new  Think\Upload();
    $upload->maxSize = 3145728;// 设置附件上传大小
    $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型D
    $picInfo = M($table)->field('picurl,picname')->where(array('id' => $id))->find();
    $upload->rootPath = "./Uploads/$file_name/";
    $info = $upload->upload();
    if (!$info) {
        $res = $upload->getError();
    } else {
        foreach ($info as $key => $val) {
            if ($key == 0) {
                $where['id'] = $id;
                $data['picurl'] = $val['savepath'];
                $data['picname'] = $val['savename'];
                if ($res = M($table)->where($where)->save($data)) {
                    //删除原图
                    unlink($upload->rootPath . $picInfo['picurl'] . $picInfo['picname']);
                } else {
                    $res = $this->error('主图更新失败');
                };
            }
        }
    }
    return $res;
}

/*沈艳艳
@param $table  string   操作的表格
@param $file_name  string   图片所在的目录
@param $id  string   id值
@param $type  string   是否删除pic与encironment里的图片的标志
*/
//图片删除
function del_pic($table,$file_name,$id){
    //更新图片信息
    $upload = new  Think\Upload();
    $picInfo=M($table)->field('picurl,picname')->where(array('id'=>$id))->find();
    $upload->rootPath="./Uploads/$file_name/";
   //删除原图
    unlink($upload->rootPath. $picInfo['picurl'] . $picInfo['picname']);
    $res = M($table)->where(array('id'=>$id))->delete();
    if($info = M('pic')->where("type_id={$id}")->select()){
        foreach($info as $v){
            unlink($upload->rootPath . $v['picurl'] . $v['picname']);
        }
        M('pic')->where("type_id={$id}")->delete();
    }
    if($info1 = M('environment')->where("type_id={$id}")->select()){
        foreach($info1 as $v1){
            unlink($upload->rootPath . $v1['picurl'] . $v1['picname']);
        }
        M('environment')->where("type_id={$id}")->delete();
    }
    if($res){
        return 1;
    }else{
        return 0;
    }
}

/*
 * User：沈艳艳
 * Date：2017/08/32
 * @param $sting 发表的言论
 * return $newString 过滤后的言论
 */
    function filter_string($string){
        $bad = array("恶心", "脏");
        $good = array("*", "*");
        $newString = str_replace($bad, $good, $string);
        return $newString;
    }
