<?php
header('Content-Type: text/html; charset=UTF-8');
if(!isset($_COOKIE['kgroup_applystatus']) || @$_COOKIE['kgroup_applystatus'] == '') {
    echo '抱歉，您没有权限访问该页面。请先申请登记后再次尝试！';
    exit();
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>请等待审核|怡红院家族</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="theme-color" content="#3979B9">
		<link rel="shortcut icon" href="static/img/favicon.ico">
		<link rel="Bookmark" href="static/img/favicon.ico" />
		<!--[if lte IE 8]><script src="static/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="static/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="static/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="static/css/ie8.css" /><![endif]-->
	</head>
	<body>

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<h1>恭喜您，申请提交成功</h1>
						<p>请耐心等候家族管理团队审核您的申请请求</p>
					</header>

				<!-- Main -->
					<div id="main">

						<!-- Content -->
							<section id="content" class="main">
								<h2>温馨提示</h2>
								<p>在此等待期间，您可以先加入家族审核专用QQ群加速审核进度哦~</p>
								<p>家族新成员审核专用QQ群号：<a href="https://jq.qq.com/?_wv=1027&k=5g4HLfG" target="_self">549584480</a><br>（点击群号可以快速唤起QQ加群）</p>
							</section>

					</div>

				<!-- Footer -->
				<footer id="footer">
					
					<section>
						<h2>社交网站公众平台</h2>
						<ul class="icons">
							<li><a href="#" class="icon fa-qq alt"><span class="label">QQ订阅号</span></a></li>
							<li><a href="#" class="icon fa-wechat alt"><span class="label">微信订阅号</span></a></li>
							<li><a href="#" class="icon fa-weibo alt"><span class="label">新浪微博</span></a></li>
						</ul>
					</section>
					<section>
						<h2>版权说明</h2>
						<p>如没有特殊声明，本页面的内容版权均归怡红院家族所有。怡红院家族对此拥有最终解释权！</p>
					</section>
					<p class="copyright">&copy; 2017 <a href="#">怡红院家族</a> Design: <a href="http://www.dingstudio.cn">DingStudio</a>.</p>
				</footer>

			</div>

		<!-- Scripts -->
			<script src="static/js/jquery.min.js"></script>
			<script src="static/js/jquery.scrollex.min.js"></script>
			<script src="static/js/jquery.scrolly.min.js"></script>
			<script src="static/js/skel.min.js"></script>
			<script src="static/js/util.js"></script>
			<!--[if lte IE 8]><script src="static/js/ie/respond.min.js"></script><![endif]-->
			<script src="static/js/main.js"></script>

	</body>
</html>