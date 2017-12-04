<?php
header('Content-type:text/html;charset=utf-8');
import('Vendor.cos.Api');
import('Vendor.cos.Auth');
import('Vendor.cos.Helper');
import('Vendor.cos.HttpClient');
import('Vendor.cos.HttpRequest');
import('Vendor.cos.HttpResponse');
import('Vendor.cos.LibcurlWrapper');
date_default_timezone_set('PRC');
/*------------------------------------------2017-10-13腾讯云服务图片视频上传----------------------------------------------*/
/*
 * User：沈艳艳
 * Date：2017-10-13
 *@param string $src 视频图片路径
 *@param string $name 上传文件名称
 *@param string $directory 上传文件目录
 * return $array $ret 返回 文件上传后文件的相关信息
*/
function cloudCos($src,$name,$directory){
    $cosApi = new Api(C('cos_domain')['cos']);
    $bucket = C('cos_domain')['domain']['domain_name'];
    //检查是否存在要上传的目录
//    $list = $cosApi->prefixSearch($bucket,'/baike/'.date('Y-m-d'), 1, '')['data']['infos'];
    $list = $cosApi->prefixSearch($bucket,$directory, 1, '')['data']['infos'];
    if(empty($list)){
//假如为空则创建此目录
       $cosApi->createFolder($bucket,$directory);
    }
    $ret = $cosApi->upload($bucket,$src,$directory."/$name");
    if($ret['code'] == 0){
        return $ret['data'];
    }else{
        return $ret['message'];
    }
}

/*------------------------------------------2017-10-17腾讯云删除文件---------------------------------------*/
function cloudMove($path){
    $cosApi = new Api(C('cos_domain')['cos']);
    $bucket = C('cos_domain')['domain']['domain_name'];
    $ret = $cosApi->delFile($bucket, $path);
    return $ret;
}

