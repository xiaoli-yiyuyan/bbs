<?php self::load('Common/header',['title' => '用户中心']); ?>
<div class="header">
    <span class="logo"></span>
    <a href="/" class="right-nav" style="margin-right:35px;">首页 | </a>
    <a href="/User/quit" class="right-nav">退出</a>

</div>
<div class="userInfo">
  <img src="<?=$user['photo']?>" class="faceImg photo" alt="">
  <span class="info_name"><?=$user['nickname']?> </span>
  <span class="changeInfo">
    <a href="/User/updateInfo">修改资料</a> | <a href="/User/updatePwd">修改密码</a>
  </span>
</div>
<div class="title-nav"><span class="title-i"></span>我的应用</div>
<div class="">
  <div class="myApplication">  <a href="/User/myBooks">我的书架</a></div>
</div>
<script type="text/javascript">
    var $file = $('<input type="file">');
    $('.photo').click(function() {
        $file.click();
    });
    $file.change(function() {
        var $this = $(this);
        var file = this.files[0];
        console.log(file);
        if (checkExt(file.name)) {
            console.log('yes');
            var fd = new FormData();
            fd.append("photo", file);
            $.ajax({
                url: "/User/photoUpload",
                type: "POST",
                // xhr: function() {  // custom xhr
                //             // myXhr = $.ajaxSettings.xhr();
                //             // if(myXhr.upload){ // check if upload property exists
                //             //     myXhr.upload.addEventListener('progress',progress, false); // for handling the progress of the upload
                //             // }
                //             // return myXhr;
                // },
                processData: false,
                contentType: false,
                data: fd,
                success: function(data) {
                    if (!data.err) {

                    }
                },
                error: function(err) {
                    console.log(err);
                }
            });
        } else {
            console.log('no');
        }
    });
    function checkExt(name) {
        var upType = ["png","gif","jpg","bmp","jpeg"];
        var fileType = /\.[^\.]+$/.exec(name);
        fileType = fileType[0].replace(".","");
        for(var p in upType){
            if(fileType == upType[p]){
                return true;
            }
        }
    }
</script>

<?php self::load('Common/footer'); ?>
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
