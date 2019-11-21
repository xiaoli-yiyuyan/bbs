<?php self::load('common/header',['title' => '后台管理-奖励设置']); ?>
<?php self::load('admin/header_nav'); ?>
<div class="content">
    <div class="namespace">
        <a href="/admin/column/">栏目管理</a> \ <div class="nav_title">水印设置</div>
    </div>

    <form id="add" class="form-group" method="post" action="/admin/save_setting">
        
        <div class="item-line item-lg">
            <div class="item-title">水印路径</div>
            <div class="item-input"><input type="text" name="forum_water_mark_path" class="input input-lg" placeholder="水印路径" value="<?=$forum_water_mark_path?>"></div>
        </div>
        
        <div class="item-line item-lg">
            <div class="column_photo" style="background-image: url(<?=$forum_water_mark_path?>)">
                <div class="column_photo_progress"></div>
            </div>
            <div>
                <div>点击上传图片选择文件</div>
                <div class="btn add_column_photo">上传图片</div>
            </div>
        </div>
        <div class="item-line item-lg">
            <div class="item-title">水印开关</div>
            <div class="item-input">
                <label><input class="input-radio" name="forum_water_mark_status" type="radio" <?=$forum_water_mark_status == '1' ? 'checked' : ''?> value="1"> 开启</label>
                <label><input class="input-radio" name="forum_water_mark_status" type="radio" <?=$forum_water_mark_status == '0' ? 'checked' : ''?> value="0"> 关闭</label>
            </div>
        </div>
        <button class="btn btn-fill btn-lg btn-block">保存</button>
    </form>
</div>
<?php self::load('common/footer_nav'); ?>

<script>
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
                    $('input[name=forum_water_mark_path]').val(data.path);
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
        $.post($this.attr('action'), $this.serialize()).then(function(data) {
            if (data.err) {
                $.alert(data.msg);
            } else {
                $.alert('保存成功');
                // location.href = '/admin/user';
            }
        });
        return false;
    });
</script>
<?php self::load('common/footer'); ?>
