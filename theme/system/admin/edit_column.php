<?php self::load('common/header',['title' => '后台管理']); ?>
<?php self::load('admin/header_nav'); ?>
<div class="content">
    <div class="namespace">
        <a href="/admin/column/">栏目管理</a> \ <div class="nav_title">编辑栏目</div>
    </div>

    <form id="add" class="form-group" method="post" action="/admin/update_column">
        <input type="hidden" name="id" value="<?=$info['id']?>">
        <input type="hidden" name="file_id" value="<?=$info['file_id']?>">
        <div class="item-line item-lg">
            <div class="item-title">名称</div>
            <div class="item-input"><input type="text" name="title" class="input input-lg" placeholder="请输入名称" value="<?=$info['title']?>"></div>
        </div>
        <div class="item-line item-lg">
            <div class="item-title">图标</div>
            <div class="item-input"><input type="text" name="photo" class="input input-lg" placeholder="可直接填写图片url" value="<?=$info['photo']?>"></div>
        </div>
        
        <div class="item-line item-lg">
            <div class="column_photo" style="background-image: url(<?=$info['photo']?>)">
                <div class="column_photo_progress"></div>
            </div>
            <div>
                <div>点击上传图片选择文件</div>
                <div class="btn add_column_photo">上传图片</div>
            </div>
        </div>
        <div class="item-line item-lg">
            <div class="item-title">版主ID</div>
            <div class="item-input"><input type="text" name="bm_id" class="input input-lg" placeholder="多个用,号隔开" value="<?=$info['bm_id']?>"></div>
        </div>
        <div class="item-line item-lg">
            <div class="item-title">会员发帖</div>
            <div class="item-input">
                <input class="input-radio" name="user_add" value="1" type="radio" <?php if ($info['user_add']) { ?>checked<?php } ?>>开启
                <input class="input-radio" name="user_add" value="0" type="radio" <?php if (!$info['user_add']) { ?>checked<?php } ?>>关闭
            </div>
        </div>
        <div class="item-line item-lg">
            <div class="item-title">帖子审核</div>
            <div class="item-input">
                <input class="input-radio" name="is_auto" value="1" type="radio" <?php if ($info['is_auto']) { ?>checked<?php } ?>>开启
                <input class="input-radio" name="is_auto" value="0" type="radio" <?php if (!$info['is_auto']) { ?>checked<?php } ?>>关闭
            </div>
        </div>
        <div class="item-line item-lg">
            --- 内容设置 ---
        </div>
        <div class="item-line item-lg">
            <div class="item-title">HTML过滤</div>
            <div class="item-input">
                <input class="input-radio" name="is_html" value="1" type="radio" <?php if ($info['is_html']) { ?>checked<?php } ?>>开启
                <input class="input-radio" name="is_html" value="0" type="radio" <?php if (!$info['is_html']) { ?>checked<?php } ?>>关闭
            </div>
            </div>
        <div class="item-line item-lg">
            <div class="item-title">开启UBB</div>
            <div class="item-input">
            
                <input class="input-radio" name="is_ubb" value="1" type="radio" <?php if ($info['is_ubb']) { ?>checked<?php } ?>>开启
                <input class="input-radio" name="is_ubb" value="0" type="radio" <?php if (!$info['is_ubb']) { ?>checked<?php } ?>>关闭 
            </div>
        </div>
        <button class="btn btn-fill btn-lg btn-block">保存</button>
    </form>
</div>
<?php self::load('common/footer_nav'); ?>

<script>
    var photo_path = '';
    $('input[name=photo]').change(function() {
        $('.column_photo').css('background-image', 'url(' + $(this).val() + ')');
    });
    var allow_type = ["png","gif","jpg","bmp","jpeg"];
    $('.add_column_photo').click(function() {
        var file_input = $('<input type="file">');
        file_input.change(upImg);
        file_input.click();
    });

    var upImg = function() {
        var e = this;
        var file = e.files[0];
        var isUp = false;
        var fileType = /\.[^\.]+$/.exec(file.name); 
        fileType = fileType[0].replace(".","");
        if (allow_type.indexOf(fileType) == -1) {
            $.alert('文件类型错误，请选择图片文件');
            return;
        }

        window.URL = window.URL || window.webkitURL;
        if(window.URL){
            var pic = $('.column_photo');
            var r = new FileReader();  
            r.readAsDataURL(file);  
            r.onload = function() {
                var img = new Image();
                img.src = this.result;
                img.onload = function(){
                    if(img.width>img.height){
                        pic.css("background-size","auto 100%");
                    }
                }
                pic.css("background-image","url("+this.result+")");
            }
            
            ajaxUpload({
                form: { 'photo': file },
                url: '/admin/uopload_column_photo',
                progress: function(e) {
                    if(e.lengthComputable){
                        var w = parseInt(e.loaded * 100 / e.total);
                        pic.find(".column_photo_progress").css("height",(100-w)+"%");
                    }
                },
                success: function(data) {
                    $('input[name=file_id]').val(data.id);
                    $('input[name=photo]').val(data.path);
                }
            });
        } else {
            $.alert('您的浏览器当前不支持在线预览上传');
        }
    }
    var ajaxUpload = function(options) {
        var fd = new FormData();
        for (var p in options.form) {
            fd.append(p, options.form[p]);
        }
        $.ajax({
            url: options.url,
            type: "POST",
            dataType: 'json',
            xhr: function() {
                myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){
                    myXhr.upload.addEventListener('progress', options.progress, false);
                }
                return myXhr;
            },
            processData: false,
            contentType: false,
            data: fd,
            success: options.success
        });
    }
    $('#add').submit(function() {
        var $this = $(this)
        // console.log($this.serializeArray());
        $.post($this.attr('action'), $this.serialize()).then(function(data) {
            // data = JSON.parse(data);
            if (data.err) {
                $.alert(data.msg);
            } else {
                location.href = '/admin/column';
            }
        });
        return false;
    });
</script>
<?php self::load('common/footer'); ?>
