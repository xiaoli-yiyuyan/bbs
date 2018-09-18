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
		<div class="flex">当前版本号：<span>V<?=$version?></span></div>
		<div class="flex">发布时间：<span><?=$datetime?></span></div>
	</div>
	<div class="content">
		<div class="nav_title">第二步：环境检测</div>
		<div class="check_box">
			<div class="nav_title">运行环境</div>
			<div class="check_title flex-box">
				<div class="flex">检测项</div>
				<div class="flex">要求</div>
				<div class="flex">推荐</div>
				<div class="flex">当前</div>
			</div>
			<?php foreach ($env as $item) { ?>
			<div class="flex-box">
				<div class="flex"><?=$item[0]?></div>
				<div class="flex"><?=$item[1]?></div>
				<div class="flex"><?=$item[2]?></div>
				<div class="flex <?=$item[4]?>"><?=$item[3]?></div>
			</div>
			<?php } ?>
		</div>

		<div class="check_box">
			<div class="nav_title">类库支持</div>
			<div class="check_title flex-box">
				<div class="flex">检测项</div>
				<div class="flex">类型</div>
				<div class="flex">状态</div>
			</div>
			<?php foreach ($func as $item) { ?>
			<div class="flex-box">
				<div class="flex"><?=$item[0]?></div>
				<div class="flex"><?=$item[3]?></div>
				<div class="flex <?=$item[2]?>"><?=$item[1]?></div>
			</div>
			<?php } ?>
		</div>

		<div class="check_box">
			<div class="nav_title">目录读写</div>
			<div class="check_title flex-box">
				<div class="flex">路径</div>
				<div class="flex">状态</div>
			</div>
			<?php foreach ($dirfile as $item) { ?>
			<div class="flex-box">
				<div class="flex"><?=$item[3]?></div>
				<div class="flex <?=$item[2]?>"><?=$item[1]?></div>
			</div>
			<?php } ?>
		</div>
		<div class="flex-box">
			<a class="btn btn-lg install" href="index.php?step=1">上一步</a>
			<a class="btn btn-fill btn-lg install flex next" href="index.php?step=3">下一步</a>
		</div>
	</div>
</body>
</html>