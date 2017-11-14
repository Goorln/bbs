<?php
/**
 * @param int $width 验证码宽度
 * @param int $height 验证码高度
 * @param int $length 验证码长度
 */
function captcha($width = 140, $height = 50, $length = 4)
{
    header("Content-type:image/png");
    /* 新建一个真彩色图像:$im */
    $im = imagecreatetruecolor($width, $height);
    /* 为图像 $im 分配背景色 */
    $bg_color = imagecolorallocate($im, mt_rand(200,255), mt_rand(200,255), mt_rand(200,255));
    /* 在图像 $im 的坐标（0,0）处用 $bg_color 颜色执行区域填充 */
    imagefill($im, 0, 0, $bg_color);
    /* 在图像 $im 上绘制3条椭圆弧 */
    for ($i = 1; $i <= 3; $i++) {
        /* 为图像 $im 分配椭圆弧颜色 */
        $arc_color = imagecolorallocate($im, mt_rand(160,240), mt_rand(160,240), mt_rand(160,240));
        imagearc($im, mt_rand($width / 4, $width * 3 / 4), mt_rand($height / 4, $height * 3 / 4), $width / 2, $height / 2, mt_rand(0, 360), mt_rand(0, 360), $arc_color);
    }
    /* 在图像 $im 上绘制6条线段*/
    for ($i = 1; $i <= 6; $i++) {
        /* 为图像 $im 分配线段颜色 */
        $line_color = imagecolorallocate($im, mt_rand(120,160), mt_rand(120,160), mt_rand(120,160));
        imageline($im,mt_rand(0,$width),mt_rand(0,$height),mt_rand(0,$width),mt_rand(0,$height),$line_color);
    }
    /* 在图像 $im 上绘制18个像素点 */
    for ($i=1;$i<=18;$i++){
        /* 为图像 $im 分配像素点颜色 */
        $pixel_color = imagecolorallocate($im, mt_rand(80,160), mt_rand(80,160), mt_rand(80,160));
        imagesetpixel($im,mt_rand(0,$width),mt_rand(0,$height),$pixel_color);
    }

    /* 绘制长度为 $length 的验证码 */
    /* 为图像 $im 分配字体 */
    $str .= '';
    $font_file = '../font/2.ttf';
    for ($i=0;$i<$length;$i++){
        /* 为图像 $im 分配像素点颜色 */
        $font_color = imagecolorallocate($im, mt_rand(40,120), mt_rand(40,120), mt_rand(40,120));
        $text = strtolower(dechex(mt_rand(0,15)));//随机生成0~15的数字，转化为16进制，得到一个0~9,A~F的字符
        $width_per_font = $width/$length;//验证码每个字符所占用的宽度
        $font_size = $height/2;//设置字符串大小
        //每个字符所占宽度大概为字体大小的2/3
        $font_offset_x = ($width_per_font - $font_size*2/3)/2;//字符串x轴偏移量
        $font_offset_y = ($height - $font_size)/2 + $font_size;//字符串y轴偏移量
        //下标为$i的字符x轴的坐标：$width_per_font * $i + $font_offset_x
        imagettftext($im,$font_size,mt_rand(-20,20),$width_per_font * $i + $font_offset_x,$font_offset_y,$font_color,$font_file,$text);
        $str .= $text;

    }
    session_start();
    $_SESSION['captcha'] = $str;
    /*清理数据缓冲区*/
    ob_clean();
    imagepng($im);
    /*销毁图像资源*/
    imagedestroy($im);
}



