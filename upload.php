<?php
$allsize = $_POST['filesize'];
//递归创建目录
function createFolder($path)
{
    if (!file_exists($path))
    {
        createFolder(dirname($path));
        mkdir($path, 0777);
    }
}
//设置 路径规则返回
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
    createFolder($up_path);
    return $up_path;
}
$ret = array();
if (isset($_FILES["file"])) {
    $up_path = getbasicpath();//设置文件路径规则 并成成文件夹
    $filename1 = $_POST['fileid'];
    $ext = explode('.',$_POST['name']);//获取 文件的名称
    $filename1 = $up_path .$filename1.'.'.$ext[1];//把fileid和后缀 当成文件名称和后缀(需要和filesize.php中ajax获取大小的文件名一致)
            if ($_FILES["file"]["error"] > 0) {
                  //错误提示
                $ret['succ'] = false;
                $ret['msg'] = '上传出错！';
            } else {
                if (file_exists( $filename1)) {//文件存在 看看是否完整
                    $size = filesize($filename1);
                    if($size < $allsize){//文件比实际文件小时
                        $data = file_get_contents($_FILES["file"]["tmp_name"]);
                        file_put_contents($filename1,$data,FILE_APPEND);
                    }
                } else {
                    $data = file_get_contents($_FILES["file"]["tmp_name"]);//获取临时文件的二进制
                    file_put_contents($filename1,$data,FILE_APPEND);//拼接到文件中
                }
                $ret['succ'] = true;
                $ret['msg'] = '上传成功！';
            }
} else {
    $ret['succ'] = false;
    $ret['msg'] = '没有选中文件！';
}

echo json_encode($ret);
