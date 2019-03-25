<?php self::load('common/header',['title' => '后台管理-系统设置']); ?>
<?php self::load('admin/header_nav'); ?>
<style>
.add_img{     
    position: relative;
    margin-right: .5rem;
    width: 3.8rem;
    height: 3.8rem;
    background-color: #FFF;
    background-position: center center;
    background-size: 100% auto;
    background-repeat: no-repeat;
}
}
.btn-image{float:right;width:180px}
</style>
<div class = "content">
    <div class="namespace">
        <a href="/admin/column/">系统管理</a> \ <div class="nav_title">系统设置</div>
    </div>
    <form id="add" class = "form-group" action="/admin/save_system" method="post">
        <div class="item-line item-lg">
            <div class="item-title">开启注册</div>
            <div class="item-input">
                <input class="input-radio" name="is_register" value="1" type="radio" <?php if(isset($is_register) && $is_register == 1){?> checked <?php }?>>开启
                <input class="input-radio" name="is_register" value="0" type="radio" <?php if(isset($is_register) && !$is_register){?> checked <?php }?>>关闭
            </div>
        </div>
        <div class="item-line item-lg">
            <div class="item-title">网站名称</div>
            <div class="item-input">
<input type="text" class="input input-lg" name="webname" <?php if(isset($webname)){?> value="<?=$webname?>"<?PHP }?>placeholder="请输入网站名">
            </div>
        </div>
        <div class="item-line item-lg">
            <div class="item-title">网站域名</div>
            <div class="item-input">
                <input type="text" class="input input-lg" name="webdomain"<?php if(isset($webdomain)){?> value="<?=$webdomain?>"<?php }?> placeholder="请输入网站域名">
            </div>
        </div>
        <div class="item-line item-lg">
            <div class="item-title">网站logo</div>
            <div class="item-input">
                <input type="text" class="input input-lg" name="weblogo" <?php if(isset($weblogo)){?> value="<?=$weblogo?>"<?php }?> placeholder="网站logo" readonly>
            </div>
        </div>
        <div class="item-line item-lg">
            <div class="item-title" style="padding: 0;">
                <div class="add_btn add_img" <?php if(isset($weblogo)){?> style="background-image:url(<?=$weblogo?>)"<?php }?>>
                    <div class="column_photo_progress" style="height:0"></div>
                </div>
            </div>
            <div class="item-input">
                    <div>点击上传图片选择文件</div>
                    <button class="btn add_column_photo btn-add-image" >选择LOGO</button>
            </div>
        </div>
        <button class="btn btn-fill btn-lg btn-block">保存</button>
    </form>
</div>
<div class="footer_nav">
    <div>安米程序 v<?=$version?> (2018新鲜出炉)</div>
    <div>本程序免费开源 官网地址 <a class="ianmi_link" href="http://ianmi.com">http://ianmi.com</a></div>
</div>
<script>
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
<script>
    $(".btn-add-image").click(function(){
        var file_input = $('<input type="file">');
        file_input.hide();
        $('body').append(file_input);
        file_input.change(upImg);
        file_input.click();        

    })
    var allow_type = ["png","gif","jpg","bmp","jpeg"];
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
            var r = new FileReader();  
            var pic = $(".add_img");
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
                url: '/admin/uopload_logo_photo',
                progress: function(e) {
                    if(e.lengthComputable){
                        var w = parseInt(e.loaded * 100 / e.total);
                        pic.find(".column_photo_progress").css("height",(100-w)+"%");
                    }
                },
                success: function(data) {
                    console.log(data)
                    if(data.err){
                        $.alert(data.msg);
                        return false;
                    }
                    $('input[name=file_id]').val(data.id);
                    $('input[name=weblogo]').val(data.path);
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
</script>