<?php self::load('common/header',['title' => '后台管理']); ?>
<?php self::load('admin/header_nav'); ?>

<div class="content">

    <div class="namespace"><a href="/admin/page/">根分类</a> /
    <?php
        $namespace_path = '/';
        foreach ($namespace_index as $item) {
            $namespace_path .= $item . '/';
    ?>
        <a href="/admin/page/?namespace=<?=$namespace_path?>"><?=$item?></a> /
    <?php } ?>
        <div class="nav_title">添加分类</div>
    </div>
    <form class="form-group" method="post" action="/admin/namespace_add?namespace=<?=$namespace_parent?>">
        <div class="item-line item-lg">
            <div class="item-title">名称</div>
            <div class="item-input"><input type="text" name="name" class="input input-lg" placeholder="请输入名称"></div>
        </div>
        <button class="btn btn-fill btn-lg btn-block">添加</button>
    </form>
</div>
<div class="footer_nav">
    <div>安米程序 v<?=$version?> (2018新鲜出炉)</div>
    <div>本程序免费开源 官网地址 <a class="ianmi_link" href="http://ianmi.com">http://ianmi.com</a></div>
</div>
<script>
    
</script>
<?php self::load('common/footer'); ?>