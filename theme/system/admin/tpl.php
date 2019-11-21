<?php self::load('common/header',['title' => '后台管理-奖励设置']); ?>
<?php self::load('admin/header_nav'); ?>
<script src="/static/js/template.js?v=<?=$version?>"></script>
<div class="content">
    <div class="namespace">
        <a href="/admin/user/">系统设置</a> \ <div class="nav_title">主题管理</div>
    </div>
    <div class="page_nav">
        <a href="/admin/tpl">主题库</a>
        <a href="/admin/my_tpl">我的主题</a>
        <!-- <a href="/admin/add_page?type=1">添加页面</a> -->
    </div>
    <div class="list">
        <?php if (empty($list['data'])) { ?>
            <div class="empty">主题商店即将上线</div>
        <?php } ?>
        <div class="list-group theme-list-group">
            <?php foreach ($list['data'] as $key => $item) {?>
                <a class="list-item" href="/admin/tpl_view?name=<?=$item['name']?>">
                    <img class="theme-logo" src="<?=$item['logoPath']?>" alt="">
                    <div class="ellipsis theme-title"><?=$item['title']?></div>
                    <div class="theme-pay-info">
                        <div><?=$item['price'] > 0 ? '￥' . $item['price'] : '免费'?></div>
                        <div><?=$item['version']?></div>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>
</div>
<?php self::load('common/footer_nav'); ?>

<script id="clone_form" type="text/html">
    <div class="list newlist">
        <div class="list-group">
            <div class="list-item ellipsis list-item-icon">
                主题名称
            </div>
            <div class="list-item ellipsis list-item-icon">
                <input type="text" name="title" value="{{=title}}">
            </div>
            <div class="list-item ellipsis list-item-icon">
                主题标识
            </div>
            <div class="list-item ellipsis list-item-icon">
                <input type="text" name="name" placeholder="主题唯一标识，唯一">
            </div>
            <div class="list-item ellipsis">
                版本号 {{=version}}
            </div>
        </div>
    </div>
</script>
<script>
    template.config({
        sTag: '{{',
        eTag: '}}'
    });
    $('#add').submit(function() {
        var $this = $(this)
        $.post($this.attr('action'), $this.serialize()).then(function(data) {
            data = JSON.parse(data);
            if (data.err) {
                $.alert(data.msg);
            } else {
                $.alert('保存成功');
                // location.href = '/admin/user';
            }
        });
        return false;
    });
    $(".btn-clone").click(function(){
        var _this = $(this);
        var name = _this.attr('name');
        var parent = _this.parents('.list-item');
        var version = parent.find(".version").text();
        var url = parent.data("url");
        var title = parent.find(".title").text();
        var data = {
            version: version,
            title: title,
        };
        $.confirm("是否克隆该主题" ,{
            yes: function(){
                $.modal({
                title: '设置主题参数',
                content: template($('#clone_form').html(), data),
                btn: [
                    function($btn) {
                        $btn.text('取消');
                    },
                    function($btn) {
                        $btn.text('确认');
                        $btn.click(function() {
                            var new_title = $(".newlist").find('input[name="title"]').val();
                            var new_name = $(".newlist").find('input[name="name"]').val();
                            if(new_name == ''){
                                $.alert('请设置标识且唯一');
                                return false;
                            }
                            $.post('/admin/clone_theme',{version:version, title: new_title, name: new_name, old_name: name, url: url},function(res){
                                 $.alert(res.msg);
                            });
                        });
                    },
                ],

            });
            }
        })
    })
</script>
<?php self::load('common/footer'); ?>
