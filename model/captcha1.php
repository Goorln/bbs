<?php

// 1, 创建画布
$img = imagecreatetruecolor(170, 40);

// 2, 填充背景色
// 2.1 创建背景色的颜色
$backcolor = imagecolorallocate($img,mt_rand(180,255),mt_rand(180,255),mt_rand(180,255));
// 2.2 填充背景
imagefill($img,0,0,$backcolor);

// 3, 产生随机验证码字符串
// 3.1, 利用array_merge和range函数拼凑出一个数组
$arr = array_merge(range('a','z'),range('A','Z'),range(0,9));
// 3.2, 打乱该数组
shuffle($arr);
// 3.3, 随机抽取若干个数组的下标值
$rand_keys = array_rand($arr,4);
// 3.4, 根据获得的下标遍历获得原数组的值
$str = '';
foreach($rand_keys as $value) {
	$str .= $arr[$value]; // $rand_keys的值是原数组$arr的下标
}
// 4,将验证码字符串写到图片上
// 4.1 计算字符间距
$span = ceil(170/(4+1));
for($i=1;$i<=4;$i++) {
	$stringcolor = imagecolorallocate($img,mt_rand(0,100),mt_rand(0,100),mt_rand(0,100));
	imagestring($img,5,$i*$span,10,$str[$i-1],$stringcolor);
}

session_start();
$_SESSION['captcha'] = $str;

// 5, 添加干扰线
for($i=1;$i<=8;$i++) {
	// 5.1 创建干扰线颜色
	$linecolor = imagecolorallocate($img,mt_rand(100,180),mt_rand(100,180),mt_rand(100,180));
	imageline($img,mt_rand(0,169),mt_rand(0,39),mt_rand(0,169),mt_rand(0,39),$linecolor);
}

// 6, 添加噪点(干扰点)
for($i=1;$i<=170*40*0.05;$i++) {
	$pixelcolor = imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
	imagesetpixel($img, mt_rand(0,169), mt_rand(0,39), $pixelcolor);
}

// 7, 输出图片
// 设置响应头信息
header("Content-type:image/png");
// 清理数据缓冲区
ob_clean();
// 输出图片制作
imagepng($img);
// 保存图片
imagepng($img,'./Hello.png');