<?php
header('Content-type:text/html;charset=utf-8');
import('Org.PHPExcel.PHPExcel');
import('Think.Image');
import('Think.Upload');

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
//百度地址解析
function addressToCoordinate($address){
    $url='http://api.map.baidu.com/geocoder/v2/?address='.$address.'&output=json&ak=rHruEsFhSddDI9biwwFosjMKcZ35Og9o';
    $json=file_get_contents($url);
    $decodeJson=json_decode($json,true);
    return $decodeJson;
}
/*沈艳艳*/
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
        ->setCellValue('D1', '用户名')
        ->setCellValue('E1', '性别')
        ->setCellValue('F1', '电话')
        ->setCellValue('G1', '数量')
        ->setCellValue('H1', '驾校/教练/指导员')
        ->setCellValue('I1', '课程')
        ->setCellValue('J1', '基地')
        ->setCellValue('K1', '支付类型')
        ->setCellValue('L1', '支付时间')
        ->setCellValue('M1', '跟单客服')
        ->setCellValue('N1', '客服备注')
        ->setCellValue('O1', '回访时间')
        ->setCellValue('P1', '最新更新人');
    foreach($data as $k => $v){
        $num=$k+2;
        if($v['sex'] == 0){
            $v['sex'] = '男';
        }else{
            $v['sex'] = '女';
        }
        if($v['pay_type'] == 0){
            $v['pay_type'] = '其他';
        }else{
            $v['pay_type'] = '支付宝';
        }
        $objPHPExcel->setActiveSheetIndex(0)
            //Excel的第A列，uid是你查出数组的键值，下面以此类推
            ->setCellValue('A'.$num, $v['id'])
            ->setCellValue('B'.$num, $v['ordcode'])
            ->setCellValue('C'.$num, date('Y-m-d H:i:s',$v['create_time']))
            ->setCellValue('D'.$num, $v['name'])
            ->setCellValue('E'.$num, $v['sex'])
            ->setCellValue('F'.$num, $v['tel'])
            ->setCellValue('G'.$num, $v['num'])
            ->setCellValue('H'.$num, $v['nickname'])
            ->setCellValue('I'.$num, $v['class_name'])
            ->setCellValue('J'.$num, $v['trainaddress'])
            ->setCellValue('K'.$num, $v['pay_type'])
            ->setCellValue('L'.$num, $v['pay_time'])
            ->setCellValue('M'.$num, $v['customer'])
            ->setCellValue('N'.$num, $v['customer_inform'])
            ->setCellValue('O'.$num, $v['return_time'])
            ->setCellValue('P'.$num, $v['lastupdate']);
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

///在线交易订单支付处理函数
//函数功能：根据支付接口传回的数据判断该订单是否已经支付成功；
//返回值：如果订单已经成功支付，返回true，否则返回false；

function checkorderstatus($ordid){
    $order=M('order');
    $ordstatus=$order->where("ordcode='$ordid'")->getField('status');
    if($ordstatus == 1){
        return false;
    }else{
        return true;
    }
}
//处理订单函数
//更新订单状态，写入订单支付后返回的数据
function orderhandle($parameter){
    $data['status'] = 2;
    $data['total_fee'] = $parameter['total_fee'];
    $data['notify_id'] = $parameter['notify_id'];
    $data['buyer_email'] = $parameter['buyer_email'];
    $data['trade_no'] = $parameter['trade_no'];
    $data['notify_time'] = $parameter['notify_time'];
    $item_order=M('order');
    //有的订单 是有相同的订单号  所以不能给这些订单的实际付款 是总的付款额
    $res = $item_order ->where("ordcode='{$parameter['out_trade_no']}'")->save($data);
    if($res){
        $log['done'] = '订单支付';
        $log['url'] = 'http://'.$_SERVER['HTTP_HOST'].'Mobile/Pay/pay_money';
        $log['uid'] = session('mid');
        D('UserLog')->add_user_log($log);
    }
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
        $upload->rootPath="./Uploads/$file_name/";
        foreach($info as $v){
            unlink($upload->rootPath . $v['picurl'] . $v['picname']);
        }
        M('pic')->where("type_id={$id}")->delete();
    }
    if($info1 = M('environment')->where("type_id={$id}")->select()){
        $upload->rootPath="./Uploads/Environment_logo/";
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
