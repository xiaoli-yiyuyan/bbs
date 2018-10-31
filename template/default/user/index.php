<?php $this->load('components/common/user_header',['title' => '用户中心']); ?>
<link rel="stylesheet" type="text/css" href="/static/css/cropper.min.css">

<script src="/static/js/cropper.min.js"></script>
<script src="/static/js/reszieimg.js"></script>
<div class="header-height"></div>
<div class="header">
    <span class="logo"></span>
    <div class="head_center">个人中心</div>
    <div class="icon-svg menu left-menu"></div>

</div>

<?php $this->load('/components/common/left_menu'); ?>

    <div class="user-info border-b">
      <img class="user-photo photo" src="<?=$userinfo['photo']?>" alt="">
      <div class="info-box">
        <div class="user-nc">
            <span><?=$userinfo['nickname']?><span class="user_lv">lv.<?=$userinfo['level']?></span></span>
        </div>
        <div class="user-ep"><?=$userinfo['explain']?></div>
        <div class="edit-info"><i class="icon-svg s_edit"></i>点击修改个人信息</div>
      </div>
    </div>
    
<a class="fans_nav flex-box" href="/user/friend">
    <div class="fans_nav_link">
        <div class="fans_nav_num"><?=$care_list['page']['count']?></div>
        <div>关注</div>
    </div>
    <div class="fans_nav_link border-l">
        <div class="fans_nav_num"><?=$fans_list['page']['count']?></div>
        <div>粉丝</div>
    </div>
</a>

<div class="change-info">

    <div class="li-box border-b message_line_item">
        <a href="/user/edit_info" class="flex-box flex">
            <i class="li-box-svg icon-svg b_message"></i>
            <div class="li-box-word">消息通知</div>
        </a>
    </div>
    <!-- <div class="li-box border-b">
        <a href="/novel/favorite/" class="flex-box">
            <div><i class="li-box-svg icon-svg b_qiqiu"></i></div>
            <div class="li-box-word">我的书架</div>
        </a>
    </div>


    <div class="li-box border-b">
        <a href="/novel/history/" class="flex-box">
            <div><i class="li-box-svg icon-svg b_pingtu"></i></div>
            <div class="li-box-word">最近历史</div>
        </a>
    </div> -->

    <!-- 论坛统计 Begin -->
    <div class="li-box border-b">
        <?php $this->load('components/user/forum_index_show', ['user_id' => $userinfo['id']]); ?>
    </div>
    <!-- 论坛统计 End -->

    <!-- 论坛评论统计 Begin -->
    <div class="li-box border-b">
        <?php $this->load('components/user/forum_reply_index_show', ['user_id' => $userinfo['id']]); ?>
    </div>
    <!-- 论坛评论统计 End -->

    <!-- <div class="li-box border-b">
        <a href="/chat/room/?id=2" class="flex-box flex">

            <i class="li-box-svg icon-svg b_youxika"></i>
            <div class="li-box-word">聊天大厅</div>
        </a>
    </div> -->

    <div class="li-box border-b">
        <a href="/user/edit_info" class="flex-box flex">
            <i class="li-box-svg icon-svg b_mofang"></i>
            <div class="li-box-word">修改资料</div>
        </a>
    </div>
    <div class="li-box border-b">
        <a href="/user/update_password" class="flex-box flex">
            <i class="li-box-svg icon-svg b_puke"></i>
            <div class="li-box-word">修改密码</div>
        </a>
    </div>
    <div class="li-box border-b">
        <a href="/user/quit" class="flex-box flex">
            <i class="li-box-svg icon-svg b_shuiqiang"></i>
            <div class="li-box-word">退出</div>
        </a>
    </div>
</div>
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
        maxSize: 90,
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
        $.post('/user/ajax_base64_upload', {'base64': base64}).then(function() {
            $.msg('更换成功');
        });
        cropper.destroy();
    });
    $('.edit-info').click(function() {
        location.href="/user/edit_info";
    });

    $('.bbs_article').click(function() {
        var id = $(this).data('id');
        if (id) {
            location.href = '/forum/view/?id=' + id;
        }
        return false;
    });

    $('.bbs_reply').click(function() {
        var id = $(this).data('forum-id');
        if (id) {
            location.href = '/forum/view/?id=' + id;
        }
        return false;
    });
</script>

<?php $this->load('components/common/footer'); ?>
