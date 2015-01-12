<?php

function getbasicpath(){
    $year = date('Y',time());//年
    $moun = date('m',time());//月
    $day = date('d',time());//日
    $orderid = '01212012';//订单号
    $type = 'visiblelight';//视频  图片  红外图片
    $num = 1;//第几次上传 需要从数据库读取 加1
    $path = 'pv-original/'.$year.'/'.$moun.'/'.$day.'/'.$orderid.'/'.$type.'/'.$num.'/';
    $basicdir = 'E:/wamp/www/httpupload/image/';
    //$exts = array('image/gif',"image/jpeg","image/png");//定义支持的格式
    //$filesize = '';//定义文件大小 现在不判断文件大小
    $up_path = $basicdir .$path;
    return $up_path;
}

$filename = $_GET['filename'];

$files = explode(',',$filename);
$data = array();
foreach($files as $k=>$v){
    //获取已经上传文件的大小
    $path = getbasicpath();
    $filepath = $path.$v;//路径 文件 拼接
    $flag = file_exists($filepath);//判断文件是否存在
    if($flag){
        $star = filesize($filepath);//获取文件大小
    }else{
        $star = 0;
    }
    $ext = explode('.',$v);
    $key = $ext[0];//拼接key  ***注意这个key要和fileArray设置的一样不然找不到对应的文件对象
    $data[$key] = $star;
}
$ret = array();
$ret['succ'] = true;
$ret['data'] = $data;
echo json_encode($ret);
