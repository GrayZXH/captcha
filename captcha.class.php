<?php 
	/**
	* 验PNG证码图片类
	*/
	class Captcha
	{	
		private $image;//图像资源
		private $width;//验证码的宽度 默认90
		private $height;//验证码的高度 默认35
		private $fontfile;//验证码的字体路径,推荐使用msyhbd.ttf

		
		function __construct($fontfile,$width=90,$height=35)
		{
			$this->width=$width;
			$this->height=$height;
			$this->image=imagecreatetruecolor($this->width, $this->height);//生成图像资源
			$white=imagecolorallocate($this->image, 225, 225,225);//设置图片背景色
			imagefill($this->image, 0, 0, $white);
			$this->fontfile=$fontfile;	//字体文件路径	
		}

	function show(){
			$x=0;//初始化$x
			$num=4;//验证码字符的个数，如果要改动的话，需要调整图片的宽度或字体大小
			$noise=mt_rand(10,20);//生成干扰元素的个数
		for ($i=0; $i < $num; $i++) { //循环输出验证码字符
			$size=mt_rand(19,20);
			$angle=mt_rand(0,60);
			$color=imagecolorallocate($this->image, mt_rand(1,180), mt_rand(1,180), mt_rand(1,180));
			$char='34567abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ';
			$text=substr($char, mt_rand(1,strlen($char)),1);//随机截取出一个字符
			$x+=$size;
			$y=$size*1.5;
			imagettftext($this->image, $size, $angle, $x, $y, $color, $this->fontfile, $text);
		}
		for ($i=0; $i < $noise; $i++) { //生成干扰元素
			$size=mt_rand(5,8);//字体大小
			$angle=mt_rand(0,3);//旋转角度
			$color=imagecolorallocate($this->image, mt_rand(100,255), mt_rand(100,225), mt_rand(100,225));
			$char='0123456789';//干扰内容
			$text=substr($char, mt_rand(1,strlen($char)),1);//随机截取出一个字符
			$x=mt_rand(0,$this->width);
			$y=mt_rand(0,$this->height);
			imagettftext($this->image, $size, $angle, $x, $y, $color, $this->fontfile, $text);
		}
		header('content-type:image/png');		
		imagepng($this->image);//输出图像
	}

	function __destruct(){

			imagedestroy($this->image);//销毁图像资源
	}

	}

 ?>