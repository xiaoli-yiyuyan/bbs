$(function() {
    var upload_data = {
        'img_data': [],
        'file_data': []
    };

    if ($('input[name=img_data]').val()) {
        upload_data.img_data = $('input[name=img_data]').val().split(',');
    }

    if ($('input[name=file_data]').val()) {
        upload_data.file_data = $('input[name=file_data]').val().split(',');
    }

    console.log(upload_data);

    var allow_type = ["png","gif","jpg","bmp","jpeg"];
    $('.add_img').click(function() {
        var file_input = $('<input type="file">');
        file_input.hide();
        $('body').append(file_input);
        file_input.change(upImg);
        file_input.click();
    });

    var allow_type_file = ["rar","zip"];
    $('.add_file').click(function() {
        var file_input = $('<input type="file">');
        file_input.change(upRar);
        file_input.click();
    });

    var upRar = function() {
        var e = this;
        var file = e.files[0];
        var isUp = false;
        var fileType = /\.[^\.]+$/.exec(file.name); 
        fileType = fileType[0].replace(".","");
        if (allow_type_file.indexOf(fileType) == -1) {
            $.alert('文件类型错误，请选择图片文件');
            return;
        }
        console.log(file);
        var box = $('<div class="file_item"><div class="file_icon icon-svg"></div><div class="file_progress_box"><div class="file_name">abc.rar</div><div class="file_progress"><div class="file_progress_bar"></div></div></div><div class="file_action"><div class="flex-box"><div class="btn_remove">--</div><div class="btn_setting">--</div></div></div></div>');
        box.find('.file_name').text(file.name + '(' + renderSize(file.size) + ')');
        $('.add_file').before(box);
        ajaxUpload({
            form: { 'file': file },
            url: '/forum/ajax_upload',
            progress: function(e) {
                if(e.lengthComputable){
                    var w = parseInt(e.loaded * 100 / e.total);
                    box.find(".file_progress_bar").css("width", w + "%");
                }
            },
            success: function(data) {
                dataAdd('file_data', data.id);
                var $remove = box.find('.btn_remove');
                $remove.addClass('btn_file_remove');
                $remove.text('删除');
                // box.find('.btn_setting').text('设置');
            }
        });
        this.remove();
    }

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
            var pic = $('<div class="img_item"><div class="progress_bg"></div><div class="progress_text">0%</div><div class="progress_del">x</div></div>');
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
            $(".add_img").before(pic);
            
            ajaxUpload({
                form: { 'file': file },
                url: '/forum/ajax_upload',
                progress: function(e) {
                    if(e.lengthComputable){
                        var w = parseInt(e.loaded * 100 / e.total);
                        pic.find(".progress_bg").css("height",(100-w)+"%");
                        pic.find(".progress_text").text(w+"%");
                    }
                },
                success: function(data) {
                    dataAdd('img_data', data.id);
                    pic.data('id', data.id);
                    var $insert = pic.find(".progress_text");
                    $insert.addClass('btn_pic_insert');
                    $insert.text("插入");

                }
            });
        } else {
            $.alert('您的浏览器当前不支持在线预览上传');
        }
    }

    $(document).on('click', '.btn_pic_insert', function() {
        insertImg($(this).parents('.img_item').data('id'));
    })

    $(document).on('click', '.progress_del', function() {
        var $parent = $(this).parents('.img_item');
        dataRemve('img_data', $parent.data('id'));
        $parent.remove();
    })


    $(document).on('click', '.btn_file_remove', function() {
        var $parent = $(this).parents('.file_item');
        dataRemve('file_data', $parent.data('id'));
        $parent.remove();
    });

    var insertImg = function(id) {
        id = id.toString();
        var index = upload_data['img_data'].indexOf(id);

        if (index >= 0) {
            var val = $('.add_context').val();
            $('.add_context').val(val + '[img_' + index + ']');
        }
    }

    var dataAdd = function(name, id) {
        upload_data[name].push(id);
        $('input[name=' + name + ']').val(upload_data[name].join(','));
    }

    var dataRemve = function(name, id) {
        id = id.toString();

        var index = upload_data[name].indexOf(id);
        if (index >= 0) {
            upload_data[name].splice(index, 1);
        }
        $('input[name=' + name + ']').val(upload_data[name].join(','));
    }

    // var options = {
    //     form: {
    //         'file': 0
    //     },
    //     url: '',
    //     progress: function(e) {

    //     },
    //     success: function(data) {

    //     }
    // };
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
    
    function renderSize(value){
        if(null==value||value==''){
            return "0 Bytes";
        }
        var unitArr = new Array("Bytes","KB","MB","GB","TB","PB","EB","ZB","YB");
        var index=0;
        var srcsize = parseFloat(value);
        index=Math.floor(Math.log(srcsize)/Math.log(1024));
        var size =srcsize/Math.pow(1024,index);
        size=size.toFixed(2);//保留的小数位数
        return size+unitArr[index];
    }

    $('#add').submit(function() {
        var $this = $(this)
        $.post($this.attr('action'), $this.serialize()).then(function(data) {
            data = JSON.parse(data);
            if (data.err) {
                $.alert(data.msg);
            } else {
                location.href = '/forum/view?id=' + data.id;
            }
        });
        return false;
    });
    this.remove();
});