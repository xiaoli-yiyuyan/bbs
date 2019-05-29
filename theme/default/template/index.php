<?php useComp("/components/common/header?title=$webname -专注于手机网站建设" ); ?>
<?php useComp("/components/common/header_menu_nav?title=$webname" ); ?>

<?php
    $tp = \Iam\Request::get('tp', 1);
    if ($tp == 2) {
        $list = source('Model/Forum/getList', [
            'type' => 1
        ]);
    } elseif ($tp == 3) {
    
        $list = source('Model/Forum/getList', [
            'type' => 5
        ]);
    } elseif ($tp == 4) {
    
        $list = source('Model/Forum/getList', [
            'type' => 6
        ]);
    } elseif ($tp == 5) {
        $list = source('Model/Forum/getList', [
            'type' => 7
        ]);
    } else {
        $list = source('Model/Forum/getList', [
            'type' => 2
        ]);
    }
?>

<div class="_index_nav">
    <div <?=$tp == 1 ? 'class="_active"' : ''?>>
        <a href="/index/index?tp=1">推荐</a>
    </div>
    <div <?=$tp == 2 ? 'class="_active"' : ''?>>
        <a href="/index/index?tp=2">最新</a>
    </div>
    <div <?=$tp == 3 ? 'class="_active"' : ''?>>
        <a href="/index/index?tp=3">话题</a>
    </div>
    <div <?=$tp == 4 ? 'class="_active"' : ''?>>
        <a href="/index/index?tp=4">图片</a>
    </div>
    <div <?=$tp == 5 ? 'class="_active"' : ''?>>
        <a href="/index/index?tp=5">文件</a>
    </div>
</div>

<div class="list img_list">
<?php foreach($list as $item) { ?>
<?php useComp('/components/forum/list_care', ['item' => $item]); ?>
<?php } ?>
</div>
<?=$list->render([
    'tp' => $tp
])?>
<?php useComp('/components/common/footer_nav', ['index' => 0]); ?>
<?php useComp('/components/common/footer'); ?>