<?php
header("Content-type:text/html;charset=utf-8");
/**
 * 文件上传(单图上传)：如果上传失败，会跳转回上传页面
 * @param array $file 上传文件的信息
 * @param array $allow_ext 允许上传的文件类型（扩展名）
 * @param int $allow_size 允许上传的文件大小
 * @param string $root_dir 上传的根目录
 * @param string $sub_dir 上传的子目录（例如：2017年09月12日上传的文件会被保存到20170912目录中，目录会自动创建）
 * @return mixed $save_name 上传后的文件名
 */
function upload($file,$allow_ext=array('jpg','png','gif'),$allow_size=2,$root_dir='../uploads/images'){
    /*如果是以数组形式上传的多张图片，禁止上传*/
    if (count($file['name'])>1) showError('暂不支持多图上传!');

    /*判断上传过程中，是否发生系统错误*/
    $error = array(
        1 => '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值',
        2 => '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值',
        3 => '文件只有部分被上传',
        4 => '没有文件被上传',
        6 => '找不到临时文件夹',
        7 => '文件写入失败'
    );
    if(array_key_exists($file['error'],$error)) showError($error[$file['error']]);

    /*判断上传过程中，是否发生逻辑错误：文件大小、文件类型、文件MIME*/
    if($file['size']>$allow_size*1024*1024) showError("文件大小不能超过{$allow_size}M，上传失败！");

    $ext = pathinfo($file['name'],4);
    if(!in_array($ext,$allow_ext)) showError('不支持该文件类型！支持的文件类型有：'.implode(',',$allow_ext));

    // $allow_mime = array('image/jpg','image/png','image/gif');
    // $check_mime = finfo_open(16);
    // $mime = finfo_file($check_mime,$file['tmp_name']);
    // if(!in_array($mime,$allow_mime)) showError('MIME类型错误！');

    /*检测上传目录是否存在*/
    $root_dir = rtrim($root_dir,'/') . '/';
    // $sub_dir = date($sub_dir).'/';
    // $sub_dir = 'images';
    if(!file_exists($root_dir)){
        if(!mkdir($root_dir,0777,true)){
            showError('创建上传目录失败！');
        }
    }

    /*随机生成一个文件名*/
    $name = randName($ext);

    $res = move_uploaded_file($file['tmp_name'],$root_dir.$name);
    if ($res){
        return $root_dir.$name;
    }else{
        showError('服务器繁忙，请稍后再试！');
    }
 }

/**
 * 显示错误信息，终止代码执行
 * @param $msg 错误信息
 */
function showError($msg){
    $http_referer = $_SERVER['HTTP_REFERER'];
    header("refresh:2;url={$http_referer}");
    die($msg);
}

/**
 * 生成随机文件名
 */
function randName($ext){
    $uniqid = uniqid('',true); // 生成一个唯一ID
    $name = str_replace('.','',$uniqid); // 将$uniqid中的点替换成空字符串
    return "$name.$ext"; // 把生成的唯一ID和传递进来的扩展名连接
}

/**
 * @param $file 上传的文件信息（多个文件以数组形式上传）
 * @return array 返回值（数组形式，数组元素为上传后的新文件名）
 */
function uploadAll($file){
    $data = array();//用于存储每次上传文件的返回值
    $num = count($file['name']);//判断上传文件的个数
    for($i=0;$i<$num;$i++){
        /*重组数组（得到$num个单图上传形式的新数组）*/
        foreach ($file as $k => $v) {
            $info[$k] = $v[$i];
        }
        $data[] = upload($info);//调用$num次upload函数将返回值，压入$data数组中
    }
    return $data;
}
