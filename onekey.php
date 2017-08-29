<?php
require_once(dirname(__FILE__).'/kernel.php'); //载入核心类库
$config = include(dirname(__FILE__).'/config.php'); //载入配置文件
$sec = new User(); //导入安全规则类
if(!$sec->checkPerm()) {
    if($config['passport_ssl']) {
        header('Location: https://'.$config['passport_srv'].'/sso/login?returnUrl='.urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));
    }
    else {
        header('Location: http://'.$config['passport_srv'].'/sso/login?returnUrl='.urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));
    }
    exit();
}
$sqlconn = DB::getInstance()->connect(); //单一实例化连接数据库
$sqlcode = "truncate songusers"; //定义SQL语句用于查询所有待审核用户信息
$result = $sqlconn->query($sqlcode); //执行查询
header('Content-Type: text/html; charset=UTF-8'); //设置UTF-8 HTML模式头，便于后续输出文字信息
if(!$result) {
    die('<h1><span style="color:red">抱歉，由于远程服务器繁忙，本次操作并没有成功执行。请稍候再次重试！</span></h1>');
}
else {
    die('<script>alert("操作成功！一键审批完成。");location.href="'.@$_GET['callback'].'";</script>');
}
