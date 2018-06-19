<?php self::load('Common/header',['title' => '查看帖子']); ?>
<div class="header">
    <span class="back"></span>
    <span class="left-word"><?=$class_info['title']?></span>
    <span class="header-right">
        <a class="icon-svg user" href="/User/index"></a>
    </span>
</div>
<div class="content-main">
    <div class="view_head border-b">
        <div class="view_title"><?=$forum_info['title']?></div>
        <div class="view_user_info">
            <div>
                <img class="view_user_info_photo" src="<?=$forum_user['photo']?>" alt="">
                <?=$forum_user['nickname']?>
            </div>
            
            <div class="create_time"><?=$forum_info['create_time']?></div>
        </div>
    </div>
    <div class="view_context">
        <?=$forum_info['context']?>
    </div>
</div>
<div class="replay_box">
    <div class="replay_title border-b">全部回复 <?=$page['count']?> 条</div>
    
<?php if (empty($list)) { ?>
    <div class="bbs_empty replay_empty">暂无评论！</div>
<?php } else { ?>
<div class="list bbs_list">
<?php foreach ($list as $item) { ?>
    <div class="list-group">
        <div class="bbs_info">
            <div class="bbs_user"><img class="bbs_user_photo" src="<?=$item['photo']?>" alt=""> <?=$item['nickname']?></div>
            <div class="create_time">
                <?=$item['create_time']?>
            </div>
        </div>
        <div class=" class="list-item"">
            <?=$item['context']?>
        </div>
    </div>
<?php } ?>
    <div class="reply_more"><a href="/forum/reply?id=<?=$forum_info['id']?>">展开全部回复 <?=$page['count']?> 条</a></div>
</div>
<?php } ?>
<div class="reply_body">
    <div class="reply_input border-t">
        <form class="reply_index" action="/forum/reply_add?way=0&amp;id=<?=$forum_info['id']?>" method="post">
            <div class="icon-svg input_face"></div>
            <input class="input_show input" name="context">
            <button class="btn btn_reply">回复</button>
        </form>
        <div class="chat-face-box transition" style="height: 0;">
            <div class="face-box">
                <span class="face-out"><img data-img="爱你"  src="/static/images/face/爱你.gif" alt="img"></span>
                <span class="face-out"><img data-img="抱抱"  src="/static/images/face/抱抱.gif" alt="img"></span>
                <span class="face-out"><img data-img="不活了"  src="/static/images/face/不活了.gif" alt="img"></span>
                <span class="face-out"><img data-img="不要"  src="/static/images/face/不要.gif" alt="img"></span>
                <span class="face-out"><img data-img="超人"  src="/static/images/face/超人.gif" alt="img"></span>
                <span class="face-out"><img data-img="大哭"  src="/static/images/face/大哭.gif" alt="img"></span>
                <span class="face-out"><img data-img="嗯嗯"  src="/static/images/face/嗯嗯.gif" alt="img"></span>
                <span class="face-out"><img data-img="发呆"  src="/static/images/face/发呆.gif" alt="img"></span>
                <span class="face-out"><img data-img="飞呀"  src="/static/images/face/飞呀.gif" alt="img"></span>
                <span class="face-out"><img data-img="奋斗"  src="/static/images/face/奋斗.gif" alt="img"></span>
                <span class="face-out"><img data-img="尴尬"  src="/static/images/face/尴尬.gif" alt="img"></span>
                <span class="face-out"><img data-img="感动"  src="/static/images/face/感动.gif" alt="img"></span>
                <span class="face-out"><img data-img="害羞"  src="/static/images/face/害羞.gif" alt="img"></span>
                <span class="face-out"><img data-img="感动"  src="/static/images/face/感动.gif" alt="img"></span>
                <span class="face-out"><img data-img="嘿咻"  src="/static/images/face/嘿咻.gif" alt="img"></span>
                <span class="face-out"><img data-img="画圈圈"  src="/static/images/face/画圈圈.gif" alt="img"></span>
                <span class="face-out"><img data-img="惊吓"  src="/static/images/face/惊吓.gif" alt="img"></span>
                <span class="face-out"><img data-img="敬礼"  src="/static/images/face/敬礼.gif" alt="img"></span>
                <span class="face-out"><img data-img="快跑"  src="/static/images/face/快跑.gif" alt="img"></span>
                <span class="face-out"><img data-img="路过"  src="/static/images/face/路过.gif" alt="img"></span>
                <span class="face-out"><img data-img="抢劫"  src="/static/images/face/抢劫.gif" alt="img"></span>
                <span class="face-out"><img data-img="杀气"  src="/static/images/face/杀气.gif" alt="img"></span>
                <span class="face-out"><img data-img="上吊"  src="/static/images/face/上吊.gif" alt="img"></span>
                <span class="face-out"><img data-img="调戏"  src="/static/images/face/调戏.gif" alt="img"></span>
                <span class="face-out"><img data-img="跳舞"  src="/static/images/face/跳舞.gif" alt="img"></span>
                <span class="face-out"><img data-img="万岁"  src="/static/images/face/万岁.gif" alt="img"></span>
                <span class="face-out"><img data-img="我走了"  src="/static/images/face/我走了.gif" alt="img"></span>
                <span class="face-out"><img data-img="喜欢"  src="/static/images/face/喜欢.gif" alt="img"></span>
                <span class="face-out"><img data-img="吓死人"  src="/static/images/face/吓死人.gif" alt="img"></span>
                <span class="face-out"><img data-img="嚣张"  src="/static/images/face/嚣张.gif" alt="img"></span>
                <span class="face-out"><img data-img="疑问"  src="/static/images/face/疑问.gif" alt="img"></span>
                <span class="face-out"><img data-img="做操"  src="/static/images/face/做操.gif" alt="img"></span>
            </div>
        </div>
    </div>
</div>
</div>
<script>
$(function() {
    $('.input_face').click(function() {
        $('.chat-face-box').height($('.chat-face-box').height() == 0 ? $('.face-box').innerHeight() : 0);
    });
    $('.face-box .face-out img').click(function() {
        var img_tag = $(this).data('img');
        var face_code = '[表情:' + img_tag + ']';
        $('.input_show').val($('.input_show').val() + face_code);
    });
});

</script>
<?php self::load('Common/footer'); ?>
