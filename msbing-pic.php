<?php
/*
微软必应搜索壁纸获取实用程序 Powered By DingStudio.Tech
Version 1.0
*/
$runlevel = $_GET['format']; //导入format参数值
$runmod = $_GET['mod']; //传入mod参数值
if ($runlevel == "css") { //确认是否以CSS方式执行
	header('Content-Type: text/css; charset=UTF-8');
	$str = file_get_contents('http://cn.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1');//调用微软api获取json
	$array = json_decode($str);//解析上面拉取到的json数据
	$imgurl = $array->{"images"}[0]->{"url"};//数组处理json，拉取url字段
	$imgurl = '//cn.bing.com'.$imgurl;//拼接必应首页域名产生图片资源链接
	echo 'body { background:fixed; background-image: url("'.$imgurl.'") }';//通过动态生成CSS应用
	exit;
}
else if ($runlevel == "redirect" and $runmod == "https") { //确认是否以重定向https方式执行
	$str = file_get_contents('http://cn.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1');//调用微软api获取json
	$array = json_decode($str);//解析上面拉取到的json数据
	$imgurl = $array->{"images"}[0]->{"url"};//数组处理json，拉取url字段
	$imgurl = 'https://cn.bing.com'.$imgurl;//拼接必应首页域名产生图片资源链接
	header('HTTP/1.1 302 Found');
	header('Location: '.$imgurl);
	exit;
}
else if ($runlevel == "redirect") { //确认是否以重定向http方式执行
	$str = file_get_contents('http://cn.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1');//调用微软api获取json
	$array = json_decode($str);//解析上面拉取到的json数据
	$imgurl = $array->{"images"}[0]->{"url"};//数组处理json，拉取url字段
	$imgurl = 'http://cn.bing.com'.$imgurl;//拼接必应首页域名产生图片资源链接
	header('HTTP/1.1 302 Found');
	header('Location: '.$imgurl);
	exit;
}
else if ($runlevel == "proxy") { //确认是否以代理输出方式执行
	$str = file_get_contents('http://cn.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1');//调用微软api获取json
	$array = json_decode($str);//解析上面拉取到的json数据
	$imgurl = $array->{"images"}[0]->{"url"};//数组处理json，拉取url字段
	$imgurl = 'http://cn.bing.com'.$imgurl;//拼接必应首页域名产生图片资源链接
	$content = file_get_contents($imgurl);
	header('Content-Type: image/png');
	echo $content;
}
else {
	header('Content-Type: text/plain; charset=UTF-8');//json输出设置
	$str = file_get_contents('http://cn.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1');//调用微软api获取json
	$array = json_decode($str);//解析上面拉取到的json数据
	$imgurl = $array->{"images"}[0]->{"url"};//数组处理json，拉取url字段
	$imgurl = '//cn.bing.com'.$imgurl;//拼接必应首页域名产生图片资源链接
	echo '您没有传递参数，系统默认以明文方式输出必应今日美图URL！URL：【'.$imgurl.'】。如果需要输出css，请在format下传参，值为css，例如 xxx.php?format=css 后端版本：2.0，小丁工作室版权所有！';//输出Json
	exit;
}
?>
