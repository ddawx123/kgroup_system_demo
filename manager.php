<?php
require_once(dirname(__FILE__).'/kernel.php'); //载入核心类库
$config = include(dirname(__FILE__).'/config.php'); //载入配置文件
$router = new Router(); //创建路由
$router->loadManager(); //载入后台管理面板动作逻辑控制器
$sqlconn = DB::getInstance()->connect(); //单一实例化连接数据库
$sqlcode = "select * from songusers order by id desc"; //定义SQL语句用于查询所有待审核用户信息
$result = $sqlconn->query($sqlcode); //执行查询
$data_row = $result->num_rows; //计算数据条目数量
if($config['passport_ssl']) {
    $exitSSO = 'https://'.$config['passport_srv'].'/sso/login.php?action=dologout&url='.urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    $goUC = 'https://'.$config['passport_srv'].'/sso/usercenter.php?action=account-config&fromUrl='.urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}
else {
    $exitSSO = 'http://'.$config['passport_srv'].'/sso/login.php?action=dologout&url='.urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    $goUC = 'http://'.$config['passport_srv'].'/sso/usercenter.php?action=account-config&fromUrl='.urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- 包含头部信息用于适应不同设备 -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 包含 bootstrap 样式表 -->
<link rel="stylesheet" href="static/css/bootstrap.min.css">
<title>后台管理系统</title>
<meta name="theme-color" content="#3979B9">
<link rel="shortcut icon" href="static/img/favicon.ico">
<link rel="Bookmark" href="static/img/favicon.ico" />
<script>
    function onekey() {
        if(!confirm('您确认要继续进行一键审批操作吗？继续后将会自动通过所有申请请求哦~')) {
            return false;
        }
        location.href = 'onekey.php?callback=manager.php';
    }
    function agree(id) {
        //TODO
        alert('独立审批功能尚未开发完成，目前暂时封禁该入口。');
    }
    function deny(id) {
        //TODO
        alert('独立审批功能尚未开发完成，目前暂时封禁该入口。');
    }
</script>
</head>
<body>
<div style="max-width:780px;width:auto;margin-left: auto;margin-right: auto;padding:5px;">
<div class="table-responsive">
<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid"> 
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example-navbar-collapse">
			<span class="sr-only">导航</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="manager.php">后台管理</a>
	</div>
	<div class="collapse navbar-collapse" id="example-navbar-collapse">
		<ul class="nav navbar-nav">
			<li><a href="manager.php">成员审核</a></li>
			<li><a href="javascript:void(0);" onclick="alert('该板块尚未开发完毕，禁止访问。');">成员管理</a></li>
			<li><a href="javascript:void(0);" onclick="alert('该板块尚未开发完毕，禁止访问。');">首页修改</a></li>
            <li><a href="javascript:void(0);" onclick="alert('该板块尚未开发完毕，禁止访问。');">导入导出</a></li>
            <li><a href="<?php echo $goUC; ?>">账号：<?php echo @$_COOKIE['dingstudio_sso']; ?></a></li>
            <li><a href="<?php echo $exitSSO; ?>">退出</a></li>
		</ul>
	</div>
	</div>
</nav>
<table align="left" width="100%" height="20" border="0" align="left" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3" class='table table-striped table-bordered'>
<tr>
    <td align="left" bgcolor="#EBEBEB"><font id="tongji">当前共有<font color="MediumSeaGreen"> <?php echo $data_row; ?></font> 人正在审核队列中等待，具体信息见下表。</td></tr>
</table>
            
              <table width='100%' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>
                <tr>
                    <th bgcolor='#EBEBEB'>昵称</th>
                    <th bgcolor='#EBEBEB'>地区</th>
                    <th bgcolor='#EBEBEB'>QQ</th>
                    <th bgcolor='#EBEBEB'>爱好</th>
                    <th bgcolor='#EBEBEB'>状态</th>
                    <th bgcolor='#EBEBEB'>操作</th>
                </tr>
                <?php
                    for ($i=0; $i<$data_row; $i++) {
                        $sql_arr = $result->fetch_assoc();
                        $oid = $sql_arr['id'];
                        $name = $sql_arr['name'];
                        $locate = $sql_arr['locate'];
                        $qqnum = $sql_arr['qqnum'];
                        $likestr = $sql_arr['likestr'];
                        echo '
                        <tr>
                        <td align="left" bgcolor="#FFFFFF"><font color="MediumSeaGreen">'.$name.'</font></td>
                        <td align="left" bgcolor="#FFFFFF"><font color="MediumSeaGreen">'.$locate.'</font></td>
                        <td align="left" bgcolor="#FFFFFF"><font color="MediumSeaGreen">'.$qqnum.'</font></td>
                        <td align="left" bgcolor="#FFFFFF"><font color="MediumSeaGreen">'.$likestr.'</font></td>
                        <td align="left" bgcolor="#FFFFFF"><font color="MediumSeaGreen">暂无</font></td>
                        <td align="left" bgcolor="#FFFFFF"><a href="javascript:void(0);" onclick="agree('.$oid.')" style="color:green">通过</a> <a href="javascript:void(0);" onclick="deny('.$oid.')" style="color:red">拒绝</a></td>
                        </tr>
                        ';
                    }
                ?>
            </table>		  
<table align="center" width="100%" height="20" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3" class='table table-striped table-bordered'>
  <tr>
    <td align="center" bgcolor="#EBEBEB">高级功能：<a href="javascript:void(0);" onclick="onekey()">一键审批所有</a></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#EBEBEB">欢迎使用后台管理系统 | &copy;2016-2017 <a href="http://www.dingstudio.cn">DingStudio</a> All Rights Reserved</td>
  </tr>
</table>
</div>
</div>
    <!-- JavaScript 放置在文档最后面可以使页面加载速度更快 -->
    <!-- 可选: 包含 jQuery 库 -->
    <script src="js/jquery.min.js"></script>
    <!-- 可选: 合并了 Bootstrap JavaScript 插件 -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>