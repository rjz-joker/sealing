<?php
	include("./config.php");
?><?php 

$id = $_GET['id'];
function cfarr($id){
$arr = explode('_',$id); 
return $arr;
}

/*	21:44 2017-01-21
*	生成小图片
*	调用方法：png();
*/

function png(){
Header("Content-type: image/PNG");
$code = 2358;
srand((double)microtime()*1000000);
$im = imagecreate(50,20);
$black = ImageColorAllocate($im, 0,0,0);
$white = ImageColorAllocate($im, 255,255,255);
$gray = ImageColorAllocate($im, 200,200,200);
imagefill($im,68,30,$gray);
imagestring($im, 5, 6, 3, $code, $white);
ImageGIF($im);
ImageDestroy($im);
}

/*
* 新浪接口说明：http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=IP地址
* 反回数据json格式：
* country 国家  province 省份  city 城市
* $jjj = sinaip('222.160.207.128');
* echo $jjj->{'province'};
*/

function sinaip($ip){

$http = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=".$ip;
$qhweb = file_get_contents($http);
$content = str_replace(';','',str_replace('var remote_ip_info = ','',$qhweb));
$json = json_decode($content);
return $json;

}

/**
 * 获得用户的真实IP地址
 *
 */
function ip() {
  static $realip = NULL;

  if ($realip !== NULL) {
    return $realip;
  }

  if (isset($_SERVER)) {
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

      /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
      foreach ($arr AS $ip) {
        $ip = trim($ip);

        if ($ip != 'unknown') {
          $realip = $ip;

          break;
        }
      }
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
      $realip = $_SERVER['HTTP_CLIENT_IP'];
    } else {
      if (isset($_SERVER['REMOTE_ADDR'])) {
        $realip = $_SERVER['REMOTE_ADDR'];
      } else {
        $realip = '0.0.0.0';
      }
    }
  } else {
    if (getenv('HTTP_X_FORWARDED_FOR')) {
      $realip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('HTTP_CLIENT_IP')) {
      $realip = getenv('HTTP_CLIENT_IP');
    } else {
      $realip = getenv('REMOTE_ADDR');
    }
  }

  preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
  $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

  return $realip;
}

/**
 * 判断客户端是否为手机
 */

function play($id){
	

	
	include "config.php";
	$agent = $_SERVER['HTTP_USER_AGENT'];
	//php判断客户端是否为手机
	if(strpos($agent,"NetFront") || strpos($agent,"iPhone") || strpos($agent,"MIDP-2.0") || strpos($agent,"Opera Mini") || strpos($agent,"UCWEB") || strpos($agent,"Android") || strpos($agent,"Windows CE") || strpos($agent,"SymbianOS")){
		 // 手机
		 if (strpos($agent, 'MicroMessenger') === false) {
			// 非微信浏览器
			include "j.php";
		} else {
			// 微信浏览器 
			include "j.php";
			//header('HTTP/1.1 301 Moved Permanently');//发出301头部 
			//header('Location:http://baidu.com');//跳转到指定地址

		}
		
	}else{
		
		png();// PC端请看图

	}

}



/*
*
*  IP黑名单限制访问
*
*/

function ph($ips,$id){
	$ip = ip(); // 取得用户IP
	$j = sinaip($ip);
	$province_user = md5($j->{'province'});//访问用户省份
	
	for($i=0;$i<=count($ips)-1;$i++){
	
		$h = sinaip($ips[$i]);
		$province_huser = md5($h->{'province'});//访问用户省份
		
		if($province_user == $province_huser){

			png();// IP黑名单地区的请看图片
		
		}else{
		
			play($id);
		
		}
	
	}

}



include "config.php";

//$chuan_zhi = '2358_1';  //http://域名/参数1_参数2_参数N.png  用几个参数传进去几个

//if($id==$chuan_zhi){ ph($ips,$id); }else{include "404.html";}



ph($ips,$id);




?> 