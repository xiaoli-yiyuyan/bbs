<?php self::load('common/header',['title' => '后台管理']); ?>
<?php self::load('admin/header_nav'); ?>

<div class="content">

    <div class="namespace">
        <a href="/admin/user/">系统设置</a> \ <a href="/admin/code/">代码自定义</a> \ <div class="nav_title">添加自定义</div>
    </div>
    <form class="form-group" method="post" action="/admin/code_edit?id=<?=$code['id']?>">
        <div class="item-line item-lg">
            <div class="item-title">名称</div>
            <div class="item-input"><input type="text" name="name" class="input input-lg" placeholder="名称，作为标识，必须唯一" value="<?=$code['name']?>"></div>
        </div>
        
        <div class="item-line item-lg">
            <div class="item-title">标题</div>
            <div class="item-input"><input type="text" name="title" class="input input-lg" placeholder="请输入名称" value="<?=$code['title']?>"></div>
        </div>
        
        <div class="item-line item-lg">
            <div>正则表达式 <a href="https://c.runoob.com/front-end/854">在线测试</a>，注意规则前后必须加上两个反斜杠“/”才能正常运行</div>
        </div>
        <div class="item-line item-lg">
            <div class="item-title">规则</div>
            <div class="item-input"><input type="text" name="preg" class="input input-lg" placeholder="请输入要替换的规则" value="<?=$code['preg']?>"></div>
        </div>
        
        <div class="item-line item-lg">
            <div class="item-title">内容</div>
            <div class="item-input">
                <textarea class="input" name="content" rows="8" placeholder="开始编写你的自定义代码吧！"><?=$code['content']?></textarea>
            </div>
        </div>
        <button class="btn btn-fill btn-lg btn-block">保存</button>
    </form>
</div>
<?php self::load('common/footer_nav'); ?>
<script>
    
</script>
<?php self::load('common/footer'); ?>
