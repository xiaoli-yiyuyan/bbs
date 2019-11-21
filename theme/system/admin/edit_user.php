<?php self::load('common/header',['title' => '后台管理']); ?>
<?php self::load('admin/header_nav'); ?>
<div class="content">
    <div class="namespace">
        <a href="/admin/user/">用户管理</a> \ <div class="nav_title">资料编辑(用户ID:<?=$info['id']?>)</div>
    </div>

    <form id="add" class="form-group" method="post" action="/admin/update_user?id=<?=$info['id']?>">
 
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
            <div class="item-title">头像</div>
            <div class="item-input"><input type="text" name="photo" class="input input-lg" placeholder="可直接填写图片url" value="<?=$info['photo']?>"></div>
        </div>
   
        <div class="item-line item-lg">
            <div class="item-title">账号</div>
            <div class="item-input"><input type="text" name="username" class="input input-lg" placeholder="账号" value="<?=$info['username']?>"></div>
        </div>   
        <div class="item-line item-lg">
            <div class="item-title">密码</div>
            <div class="item-input"><input type="text" name="password" class="input input-lg" placeholder="不修改请留空"></div>
        </div>
        <div class="item-line item-lg">
            <div class="item-title">昵称</div>
            <div class="item-input"><input type="text" name="nickname" class="input input-lg" placeholder="昵称" value="<?=$info['nickname']?>"></div>
        </div>
        <div class="item-line item-lg">
            <div class="item-title">签名</div>
            <div class="item-input"><input type="text" name="explain" class="input input-lg" placeholder="签名" value="<?=$info['explain']?>"></div>
        </div>
        <div class="item-line item-lg">
            <div class="item-title">VIP</div>
            <div class="item-input vip_level_data">
                <select class="input input-lg" name="vip_level" id="">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <input class="input input-lg" name="vip_time" type="date" value="<?=date('Y-m-d', strtotime($info['vip_time']))?>"/>
            </div>
        </div>
        
        <div class="item-line item-lg">
            <div class="item-title">金币</div>
            <div class="item-input"><input type="text" name="coin" class="input input-lg" placeholder="金币" value="<?=$info['coin']?>"></div>
        </div>
        <div class="item-line item-lg">
            <div class="item-title">点券</div>
            <div class="item-input"><input type="text" name="money" class="input input-lg" placeholder="点券" value="<?=$info['money']?>"></div>
        </div>
        <div class="item-line item-lg">
            <div class="item-title">经验</div>
            <div class="item-input"><input type="text" name="exp" class="input input-lg" placeholder="经验" value="<?=$info['exp']?>"></div>
        </div>
        <div class="item-line item-lg">
            <div class="item-title">邮箱</div>
            <div class="item-input"><input type="text" name="email" class="input input-lg" placeholder="邮箱" value="<?=$info['email']?>"></div>
        </div>
        <div class="item-line item-lg">
            <div class="item-title">锁定</div>
            <div class="item-input"><input class="input input-lg" name="lock_time" type="datetime" value="<?=$info['lock_time']?>"/></div>
        </div>
        
        <div class="item-line item-lg">
            <div class="item-title">注册IP</div>
            <div class="item-input"><?=$info['create_ip']?></div>
        </div>
        <div class="item-line item-lg">
            <div class="item-title">注册时间</div>
            <div class="item-input"><?=$info['create_time']?></div>
        </div>
        <div class="item-line item-lg">
            <div class="item-title">活动时间</div>
            <div class="item-input"><?=$info['last_time']?></div>
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
                url: '/admin/uopload_user_photo',
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
        $.post($this.attr('action'), $this.serialize()).then(function(data) {
            if (data.err) {
                $.alert(data.msg);
            } else {
                location.href = '/admin/user';
            }
        });
        return false;
    });
</script>
<?php self::load('common/footer'); ?>
