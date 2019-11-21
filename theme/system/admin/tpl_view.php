<?php self::load('common/header',['title' => '后台管理-奖励设置']); ?>
<?php self::load('admin/header_nav'); ?>
<script src="/static/js/template.js?v=<?=$version?>"></script>
<script src="/static/js/fly-zomm-img.min.js?v=<?=$version?>"></script>

<div class="content">
    <div class="namespace">
        <a href="#">系统设置</a> \ <a href="#">主题管理</a> \ <div class="nav_title">查看主题</div>
    </div>
    <div class="theme_view">
        <div class="theme_view_logo_group">
            <div class="theme_view_logo_group_box">
            <?php foreach ($view['logo_path'] as $logo) { ?>
                <img class="theme_view_logo" src="<?=$logo?>" alt="">
            <?php } ?>
            </div>
        </div>

        <div class="theme_view_title">
            <?=$view['title']?>
        
            <?php if ($is['download'] && !$is['self']) { ?>
                <span class="theme_clone_title">(克隆的主题)</span>
            <?php } ?>

        </div>
        <div class="theme-pay-info">
            <div><span class="price"><?=$view['price'] > 0 ? '￥' . $view['price'] : '免费'?></span></div>
            <!-- 大小：1.2M -->
            <div>
                版本：v<?=$view['version']?>
                <?php if ($is['download']) { ?>
                    | 本地: v<?=$localTheme['version']?>
                    <?php if ($is['update']) { ?>
                        <span>更新</span>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <div class="theme_view_memo_title">
            主题说明
        </div>
        <div class="theme_view_memo close">
            <?=$view['memo']?>
        </div>
        <?php if ($is['get']) { ?>
            <?php if ($is['download']) { ?>
                <?php if ($localTheme['status'] == 1) { ?>
                    <div class="theme_view_btn disable">
                        已应用
                    </div>
                <?php } else { ?>
                    <a class="theme_view_btn" href="/admin/themeUse?id=<?=$localTheme['id']?>">
                        应用
                    </a>
                <?php } ?>
            <?php } else { ?>
                <a class="theme_view_btn" href="/admin/installTheme?name=<?=$view['name']?>">
                    安装
                </a>
            <?php } ?>
        <?php } else { ?>
            <div class="theme_view_btn">
                获取（<?=$view['price'] > 0 ? '￥' . $view['price'] : '免费'?>）
            </div>
        <?php } ?>
        <div class="theme_other">
            <?php if ($is['get']) { ?>
                <a class="other_btn" data-href="/admin/cloneTheme?name=<?=$localTheme['name'] ?? $view['name']?>">克隆</a>
            <?php } ?>

            <?php if ($is['download'] && $localTheme['status'] == 1) { ?>
                <a class="other_btn" href="/admin/theme/setting?id=<?=$localTheme['id']?>">配置</a>
            <?php } ?>
            
            <?php if ($is['download'] && !$is['self']) { ?>
                <!-- <div class="other_btn">修改</div> -->
            <?php } ?>

            <?php if ($is['download'] && !$is['system'] && $localTheme['status'] != 1) { ?>
                <a class="other_btn" data-href="/admin/deleteTheme?id=<?=$localTheme['id']?>">删除</a>
            <?php } ?>
        </div>
        <!--
            未购买              购买
            已购买未安装        安装|克隆
            已经安装            应用|克隆|升级|删除
            已经克隆            应用|克隆|修改|删除
            系统主题            应用|克隆
        -->
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

    $('.btn-install').click(function() {
        var _this = $(this);
        var name = _this.attr('name');
        var parent = _this.parents('.list-item');
        var version = parent.find(".version").text();
        var url = parent.data("url");
        var title = parent.find(".title").text();

        $.confirm("是否安装该主题？安装的主题不可以修改，但是可以升级" ,{
            yes: function(){
                var new_title = $(".newlist").find('input[name="title"]').val();
                var new_name = $(".newlist").find('input[name="name"]').val();
                if(new_name == ''){
                    $.alert('请设置标识且唯一');
                    return false;
                }
                $.post('/admin/clone_theme',{version:version, title: title, name: name, old_name: name, url: url},function(res){
                        $.alert(res.msg);
                });
            }
        });
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
        $.confirm("是否克隆该主题？克隆的主题不可以升级，但是可以自定义修改" ,{
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

    $('.theme_view_memo').click(function() {
        $(this).toggleClass('close');
    });
    $('[data-href]').click(function() {
        var $this = $(this);
        $.confirm("是否进行[" + $this.text() + "]操作" ,{
            yes: function(){
                location.href = $this.data('href');
            }
        });
    });

    $(function (){
        $('.theme_view_logo_group_box').FlyZommImg({
            // screenHeight: 0,
            rollSpeed:200,//切换速度
            miscellaneous:true,//是否显示底部辅助按钮
            closeBtn:true,//是否打开右上角关闭按钮
            hideClass:'hide',//不需要显示预览的 class
            imgQuality:'original',//图片质量类型  thumb 缩略图  original 默认原图
            slitherCallback:function (direction,DOM) {//左滑动回调 两个参数 第一个动向 'left,firstClick,close' 第二个 当前操作DOM
//                   console.log(direction,DOM);
            }
        });
    });
</script>
<?php self::load('common/footer'); ?>
