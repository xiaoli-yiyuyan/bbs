<?php self::load('Common/header',['title' => '用户中心']); ?>
<link rel="stylesheet" type="text/css" href="/static/css/cropper.min.css">

<script src="/static/js/cropper.min.js"></script>
<script src="/static/js/reszieimg.js"></script>

<style>
.userInfo {width: 100%;height: auto;display: block;}
.faceImg {height: 120px;width: 120px;margin: 20px;border: 1px solid #cdcdcd;border-radius: 60px;}
.info_name{
    float: right;
    margin-right: 35%;
    color: #1B95E6;
    margin-top: 10%;
    font-size: 16px;
    font-family: 微软雅黑;
  }
.changeInfo {
  float: right;
  margin-right: 17%;
  color: #151617;
  margin-top: -20%;
  font-family: 微软雅黑;
  width: 140px;
}
.title-nav{font-family: 微软雅黑;font-size: 16px}
.changeInfo a:link,.myApplication a:link {color: #151617}
.changeInfo a:hover,.myApplication a:hover {color: #FD9393}
.changeInfo a:visited,.myApplication a:visited {color: #151617}
.myApplication{margin-top: 5px;border-bottom: 1px solid #f9f9f9}
.myApplication a{margin-top: 5px;height: 40px;line-height: 40px;margin-left: 20px;border-left: 2px solid #f66;padding:2px 0 2px 10px;}
</style>
<div class="header">
    <span class="logo"></span>
    <div class="head_center">个人中心</div>
    <div></div>
    <!-- <a href="/User/quit" class="icon-svg s_setting"></a> -->

</div>

    <div class="user-info border-b">
      <img class="user-photo photo" src="<?=$user['photo']?>" alt="">
      <div class="info-box">
        <div class="user-nc"><?=$user['nickname']?></div>
        <div class="user-ep"><?=$user['explain']?></div>
        <div class="edit-info"><i class="icon-svg s_edit"></i>点击修改个人信息</div>
      </div>
    </div>
<!-- <div class="user-info flex-box">
    <div>
        <img src="<?=$user['photo']?>" class="faceImg photo" id="image" alt="">
    </div>
    <div class="flex info-box">
        <div>昵称：<?=$user['nickname']?></div>
        <div>称号：秀才</div>
        <div>等级：<?=$user['level']?>(<?=$user['now_exp']?>/<?=$user['next_exp']?>)</div>
        <div>财富：<?=$user['coin']?></div>
    </div>
</div> -->
<div class="change-info flex-box">
    <div class="li-box flex flex-box">
        <a href="/User/updateInfo" class="flex-box flex">
            <div>
                <i class="li-box-svg icon-svg b_mofang"></i>
                <div class="li-box-word">修改资料</div>
            </div>
        </a>
        <a href="/User/updatePwd" class="flex-box flex">
            <div>
                <i class="li-box-svg icon-svg b_puke"></i>
                <div class="li-box-word">修改密码</div>
            </div>
        </a>
    </div>
    <div class="li-box flex-box flex">
        <a href="/chat/room/?id=2" class="flex-box flex">
            <div>

                <i class="li-box-svg icon-svg b_youxika"></i>
                <div class="li-box-word">聊天大厅</div>
            </div>
        </a>
        <a href="/User/quit" class="flex-box flex">
            <div>
                <i class="li-box-svg icon-svg b_shuiqiang"></i>
                <div class="li-box-word">退出</div>
            </div>
        </a>
    </div>
</div>
<!-- <div class="title-nav"><span class="title-i"></span>我的应用</div>
<div class="">
  <div class="myApplication">  <a href="/User/myBooks">我的书架</a></div>
  <div class="myApplication">  <a href="/User/myBooks">我的书架</a></div>
  <div class="myApplication">  <a href="/User/myBooks">我的书架</a></div>
  <div class="myApplication">  <a href="/User/myBooks">我的书架</a></div>

</div> -->
<div class="select-photo-page">
    
    <div class="header">
        <span class="header-back">
            <span class="back-word back-info">
            < 返回
            </span>
        </span>
        <span class="header-nav">
            <span class="nav-word btn-save">
                保存
            </span>
        </span>
    </div>

    <div class="select-photo">
        <img src="" alt="">
    </div>
</div>
<script type="text/javascript">
    var $file = $('<input type="file">');
    var cropper;
    var $img = $('.select-photo img');

    $file.localResizeIMG({
        maxSize: 400,
        error: function(msg) {
            $.alert(msg);
        },
        success: function(result, __this) {
            $('.select-photo-page').show();
            $img.attr('src', result.base64);
            cropper = new Cropper($img[0], {
                aspectRatio: 1/1
            })
        }
    });
    $('.photo').click(function() {
        var $this = $(this);
        $.alert('从相册中选择', function() {
            $file.click();
        });
    });
    $('.back-info').click(function() {
        $('.select-photo-page').hide();
        console.log(cropper.getImageData());
        cropper.destroy();
    });
    $('.btn-save').click(function() {
        $('.select-photo-page').hide();
        var base64 = cropper.getCroppedCanvas().toDataURL('image/png');
        $('.photo').attr('src', base64);
        $.post('/user/base64Upload', {'base64': base64}).then(function() {
            $.msg('更换成功');
        });
        cropper.destroy();
    });
    $('.edit-info').click(function() {
        location.href="/User/updateInfo";
    });
    // $file.change(function() {
    //     var $this = $(this);
    //     var file = this.files[0];
    //     console.log(file);
    //     if (checkExt(file.name)) {
    //         console.log('yes');
    //         var fd = new FormData();
    //         fd.append("photo", file);
    //         $.ajax({
    //             url: "/User/photoUpload",
    //             type: "POST",
    //             // xhr: function() {  // custom xhr
    //             //             // myXhr = $.ajaxSettings.xhr();
    //             //             // if(myXhr.upload){ // check if upload property exists
    //             //             //     myXhr.upload.addEventListener('progress',progress, false); // for handling the progress of the upload
    //             //             // }
    //             //             // return myXhr;
    //             // },
    //             processData: false,
    //             contentType: false,
    //             data: fd,
    //             success: function(data) {
    //                 if (!data.err) {

    //                 }
    //             },
    //             error: function(err) {
    //                 console.log(err);
    //             }
    //         });
    //     } else {
    //         console.log('no');
    //     }
    // });
    // function checkExt(name) {
    //     var upType = ["png","gif","jpg","bmp","jpeg"];
    //     var fileType = /\.[^\.]+$/.exec(name);
    //     fileType = fileType[0].replace(".","");
    //     for(var p in upType){
    //         if(fileType == upType[p]){
    //             return true;
    //         }
    //     }
    // }
</script>

<?php self::load('Common/footer'); ?>
