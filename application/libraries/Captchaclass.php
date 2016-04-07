<?php

/**
 * 验证码类
 */
class Captchaclass {

    // 要显示的字符
    private $str;
    // 验证码
    public $code;

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->str = "1,2,3,4,5,6,7,8,9,a,b,c,d,f,g";
    }

    /**
     * 按照数字子项的一个值排序
     */
    public function create()
    {
        header("Content-type: image/png");

        $list = explode(",", $this->str);
        $cmax = count($list) - 1;
        $verifyCode = '';
        for ( $i=0; $i < 5; $i++ ){
            $randnum = mt_rand(0, $cmax);
            //取出字符，组合成为我们要的验证码字符
            $verifyCode .= $list[$randnum];
        }

        //将字符放入属性中
        $this->code = $verifyCode;

        $im = imagecreate(58,28);    //生成图片
        $black = imagecolorallocate($im, 0,0,0);
        //此条及以下三条为设置的颜色
        $white = imagecolorallocate($im, 255,255,255);
        $gray = imagecolorallocate($im, 200,200,200);
        $red = imagecolorallocate($im, 255, 0, 0);
        //给图片填充颜色
        imagefill($im,0,0,$white);

        //将验证码绘入图片
        imagestring($im, 5, 10, 8, $verifyCode, $black);

        for($i=0;$i<50;$i++){
            imagesetpixel($im, rand(), rand(), $black);
            imagesetpixel($im, rand(), rand(), $red);
            imagesetpixel($im, rand(), rand(), $gray);
        }
        imagepng($im);
        imagedestroy($im);
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        // TODO
    }
}