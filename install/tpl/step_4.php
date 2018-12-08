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
    <style>
        .install {
            display: block;
        }
	</style>
	
	<div class="version flex-box">
		<div class="flex">安装结果</div>
	</div>
	<div class="content">
		<?php if ($err) { ?>
			<div class="install_error"><?=$msg?></div>
			<a class="btn btn-fill btn-lg install" href="index.php?step=3">返回上一步</a>
		<?php } else { ?>
			
			<div class="install_success">
				<div class="i_s_str">恭喜你安装成功</div>
				<div>提示：后台地址为 http://域名/admin</div>
				<div>提示：网站注册的第一个会员就是管理员</div>
				<div>本程序永久开源且免费</div>
				<div class="tips">
					<div>世界上没有完美的程序</div>
					<div>只有不断的改进</div>
					<div>你<span class="red">宝贵的意见</span>才是明灯</div>
					<div>才能在黑暗中找到前进的方向</div>
					<div class="by">BY 安米</div>
				</div>
				<div>安米官网 <a href="http://ianmi.com">http://ianmi.com</a></div>
				<div class="s_tips">重要：安米程序安装成功，请手动删除安装程序！</div>
				<div class="s_tips">重要：安米程序安装成功，请手动删除安装程序！</div>
				<div class="s_tips">重要：安米程序安装成功，请手动删除安装程序！</div>
			</div>
			
			<div class="flex-box">
				<a class="btn btn-fill btn-lg flex" href="/">进入网站首页</a>
				<a class="btn btn-fill btn-lg flex next" href="/admin">进入管理后台</a> 
			</div>
		<?php } ?>
	</div>
</body>
</html>