<?php
use JPush\Client;
//生成密码
function mym($str,$name){
    $p1 = md5($str.$name);
    $p2 = sha1($str.$name);
    $pass = substr($p1,0,6);
    $pass.=substr($p2,0,6);
    $pass.=substr($p1,20,6);
    $pass.=substr($p2,20,6);
    $pass.=substr($p1,30,2);
    $pass.=substr($p2,30,6);
    return strtolower($pass);
}
//记录用户日志
function managelog($account,$username,$log){
    $data['account']=$account;
    $data['username']=$username;
    $data['ntime']=time();
    $data['info']=$log;
    $data['nip']=sprintf('%u',ip2long($_SERVER['REMOTE_ADDR']));
    M('adminlog')->add($data);
}


//地标
//返回课程
function send_admin($alias,$message,$type){
    Vendor('JPush.Client');
    Vendor('JPush.Config');
    Vendor('JPush.DevicePayload'); Vendor('JPush.Http');
    Vendor('JPush.PushPayload');Vendor('JPush.ReportPayload');
    Vendor('JPush.SchedulePayload'); Vendor('JPush.version');
    Vendor('JPush.Exceptions.APIConnectionException');Vendor('JPush.Exceptions.JPushException');
    Vendor('JPush.Exceptions.APIRequestException');
    $appKey ='fad71f0a96f4dc6626afe2d2';// getenv('app_key');
    $masterSecret='a4870316e6178b8790c5bd93';//getenv('master_secret');
    $client=new Client($appKey,$masterSecret);
    try {
        $response = $client->push();
        if($alias!=''){
           $response= $response->setPlatform("all")
            ->addAlias($alias);
        }else{
            
            if($type=='all'){
                 $response= $response->setPlatform("all")
                 ->setAudience("all");
            }else{
                 $response= $response->setPlatform("all")
                ->addTag($type);
            }
        }
        //->addAlias($alias)
        // 一般情况下，关于 audience 的设置只需要调用 addAlias、addTag、addTagAnd  或 addRegistrationId
        // 这四个方法中的某一个即可，这里仅作为示例，当然全部调用也可以，多项 audience 调用表示其结果的交集
        // 即是说一般情况下，下面三个方法和没有列出的 addTagAnd 一共四个，只适用一个便可满足大多数的场景需求
        //        ->iosNotification("11111111",array("alert"=> "我要去学车!",'sound' => 'defult',
        //             "badge"=>"+1",'extras'=> array('key' => 'value'),
        //         ))
        $response->iosNotification($message,array("alert"=> "我要去学车!",'sound' => 'defult',"badge"=>"+1",)
            )->androidNotification($message,array('title' => 'hello jpush',"badge"=>"+1"
            ))->options(array('apns_production' => false,
            ))->send();
    } catch (\JPush\Exceptions\APIConnectionException $e) {
    	file_put_contents("/a/adminJPushlog.txt", $e.'-时间-'.time()."\r\n",FILE_APPEND);
    } catch (\JPush\Exceptions\APIRequestException $e) {
    	file_put_contents("/a/adminJPushlog.txt", $e.'-时间-'.time()."\r\n",FILE_APPEND);
	}
}
