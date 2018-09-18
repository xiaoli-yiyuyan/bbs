<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="baidu-site-verification" content="HmdI3Pb6F4" />
	<meta name="viewport" content="initial-scale=1.0,width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
	<title>安装程序</title>
	<meta name="keywords" content="建站,手机建站,程序,建站程序,wap,wap程序,免费程序,开源程序,免费开源程序,安米程序,安米cms,wapcms,小说程序,论坛程序,手机论坛" />
	<meta name="description" content="安米建站程序，打造纯移动端建站程序。" />
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" href="/static/ui/style.css">
	<link rel="stylesheet" href="/install/style.css">
	<script src="/static/js/jquery.js"></script>
	<script src="/static/ui/ui.js"></script>
</head>
<body>
	<div class="version flex-box">
		<div class="flex">基础数据库安装</div>
	</div>
	<form class="content" action="index.php?step=4" method="post">
	<div class="nav_title">第三步：数据库配置</div>

		<div class="input_group">
			<div class="item-line item-lg">
				<div class="item-title">服务器</div>
				<div class="item-input"><input type="text" class="input input-lg" name="host" placeholder="数据库服务器" value="127.0.0.1"></div>
			</div>
			<div class="item-line item-lg">
				<div class="item-title">库名</div>
				<div class="item-input"><input type="text" class="input input-lg" name="dbname" placeholder="数据库名" value="love_ianmi"></div>
			</div>
			<div class="item-line item-lg">
				<div class="item-title">用户名</div>
				<div class="item-input"><input type="text" class="input input-lg" name="user" placeholder="数据库用户名" value="root"></div>
			</div>
			<div class="item-line item-lg">
				<div class="item-title">密码</div>
				<div class="item-input"><input type="text" class="input input-lg" name="pass" placeholder="数据库密码" value="root"></div>
			</div>
			<div class="item-line item-lg">
				<div class="item-title">端口</div>
				<div class="item-input"><input type="text" class="input input-lg" name="port" placeholder="数据库端口" value="3306"></div>
			</div>
		</div>
		<div class="flex-box">
			<a class="btn btn-lg install" href="index.php?step=2">上一步</a>
			<button class="btn btn-fill btn-lg install flex next">下一步</button>
		</div>
	</form>

</body>
</html>