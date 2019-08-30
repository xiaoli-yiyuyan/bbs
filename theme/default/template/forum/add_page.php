<?php useComp('/components/common/user_header', ['title' => '帖子发布']); ?>
<?php useComp('/components/common/header_nav', ['title' => '内容发布']); ?>
<script src="/static/js/iamEditor.min.js?v=<?=$version?>"></script>
<div class="_edit_forum">
    <input type="text" class="_add_forum_title" placeholder="在这里输入标题">
    <div class="_edit_content" placeholder="说点啥好呢？"></div>
    <div class="_edit_tools_block"></div>
    <div class="_edit_tools">
        <div class="_menu">
            <div class="_add_title _add_title_active">添加标题</div>
            <div class="_add_face icon-svg" wd="表情"></div>
            <div class="_add_hr icon-svg" wd="分割线"></div>
            <div class="_add_image icon-svg" wd="图片"></div>
            <div class="_add_file icon-svg" wd="文件"></div>
        </div>
            
        <div class="_face_box chat-face-box transition" style="height: 0;">
            <div class="face-box">
                <span class="face-out"><img data-img="爱你"  src="/static/images/face/aini.gif" alt="爱你"></span>
                <span class="face-out"><img data-img="抱抱"  src="/static/images/face/baobao.gif" alt="抱抱"></span>
                <span class="face-out"><img data-img="不活了"  src="/static/images/face/buhuole.gif" alt="不活了"></span>
                <span class="face-out"><img data-img="不要"  src="/static/images/face/buyao.gif" alt="不要"></span>
                <span class="face-out"><img data-img="超人"  src="/static/images/face/chaoren.gif" alt="超人"></span>
                <span class="face-out"><img data-img="大哭"  src="/static/images/face/daku.gif" alt="大哭"></span>
                <span class="face-out"><img data-img="嗯嗯"  src="/static/images/face/enen.gif" alt="嗯嗯"></span>
                <span class="face-out"><img data-img="发呆"  src="/static/images/face/fadai.gif" alt="发呆"></span>
                <span class="face-out"><img data-img="飞呀"  src="/static/images/face/feiya.gif" alt="飞呀"></span>
                <span class="face-out"><img data-img="奋斗"  src="/static/images/face/fendou.gif" alt="奋斗"></span>
                <span class="face-out"><img data-img="尴尬"  src="/static/images/face/ganga.gif" alt="尴尬"></span>
                <span class="face-out"><img data-img="感动"  src="/static/images/face/gandong.gif" alt="感动"></span>
                <span class="face-out"><img data-img="害羞"  src="/static/images/face/haixiu.gif" alt="害羞"></span>
                <span class="face-out"><img data-img="嘿咻"  src="/static/images/face/heixiu.gif" alt="嘿咻"></span>
                <span class="face-out"><img data-img="画圈圈"  src="/static/images/face/huaquanquan.gif" alt="画圈圈"></span>
                <span class="face-out"><img data-img="惊吓"  src="/static/images/face/jinxia.gif" alt="惊吓"></span>
                <span class="face-out"><img data-img="敬礼"  src="/static/images/face/jingli.gif" alt="敬礼"></span>
                <span class="face-out"><img data-img="快跑"  src="/static/images/face/kuaipao.gif" alt="快跑"></span>
                <span class="face-out"><img data-img="路过"  src="/static/images/face/luguo.gif" alt="路过"></span>
                <span class="face-out"><img data-img="抢劫"  src="/static/images/face/qiangjie.gif" alt="抢劫"></span>
                <span class="face-out"><img data-img="杀气"  src="/static/images/face/shaqi.gif" alt="杀气"></span>
                <span class="face-out"><img data-img="上吊"  src="/static/images/face/shangdiao.gif" alt="上吊"></span>
                <span class="face-out"><img data-img="调戏"  src="/static/images/face/tiaoxi.gif" alt="调戏"></span>
                <span class="face-out"><img data-img="跳舞"  src="/static/images/face/tiaowu.gif" alt="跳舞"></span>
                <span class="face-out"><img data-img="万岁"  src="/static/images/face/wanshui.gif" alt="万岁"></span>
                <span class="face-out"><img data-img="我走了"  src="/static/images/face/wozoule.gif" alt="我走了"></span>
                <span class="face-out"><img data-img="喜欢"  src="/static/images/face/xihuan.gif" alt="喜欢"></span>
                <span class="face-out"><img data-img="吓死人"  src="/static/images/face/xiasiren.gif" alt="吓死人"></span>
                <span class="face-out"><img data-img="嚣张"  src="/static/images/face/xiaozhang.gif" alt="嚣张"></span>
                <span class="face-out"><img data-img="疑问"  src="/static/images/face/yiwen.gif" alt="疑问"></span>
                <span class="face-out"><img data-img="做操"  src="/static/images/face/zuocao.gif" alt="做操"></span>
            </div>
        </div>
    </div>
</div>
<script>
    var iamEditor = new IamEditor();
    iamEditor.getBox(document.querySelector('._edit_content'));

    $('._add_face').click(function() {
        $('.chat-face-box').height($('.chat-face-box').height() == 0 ? $('.face-box').innerHeight() : 0);
    });
    $('.face-box .face-out img').click(function() {
        var img_tag = $(this).data('img');
        var face_code = '[表情:' + img_tag + ']';
        iamEditor.insertHTML('<img data-code="' + face_code + '" class="face-chat" src="' + $(this).attr('src') + '"/>');
        // $('.input_show').val($('.input_show').val() + face_code);
    });
    
    // $('._add_image').click(function() {
    //         $.modal({
    //             title: '爆款手机',
    //             content: '<div class="list">\
    //         <div class="list-group">\
    //             <div class="list-item ellipsis list-item-icon">\
    //                 <img src="images/1.jpg" alt="">\
    //                 Apple 苹果 iPhone 6s Plus (A1699) 16G 玫瑰金色 移动联通电信4G 全网通手机\
    //             </div>\
    //             <div class="list-item ellipsis list-item-icon">\
    //                 <img src="images/1.jpg" alt="">\
    //                 Letv 乐视1S 乐1S 移动联通双4G 双卡双待 16GB 金</div>\
    //             <div class="list-item ellipsis">NOKIA/诺基亚 2610 nokia 2610 经典诺基亚直板手机 学生备用老人手机 诺基亚低端功能机</div>\
    //             <div class="list-item ellipsis">华为 Mate8 NXT-TL00 3GB+32GB版 移动定制 月光银</div>\
    //             <div class="list-item ellipsis">锤子 坚果 32GB 红色 移动联通4G手机 双卡双待&gt;</div>\
    //         </div>\
    //     </div>',
    //             btn: [
    //                 function($btn) {
    //                     $btn.text('管理');
    //                     $btn.click(function() {
    //                         $.alert('点击了按钮一');
    //                     });
    //                 },
    //                 function($btn) {
    //                     $btn.text('取消');
    //                     $btn.click(function() {
    //                         $.alert('点击了按钮二');
    //                     });
    //                 },
    //                 function($btn) {
    //                     $btn.text('查看>>');
    //                     $btn.click(function() {
    //                         $.alert('点击了按钮三');
    //                     });
    //                 }
    //             ]
    //         });
    //     });

    var face = [
        { name: "爱你", src: "aini.gif" },
        { name: "抱抱", src: "baobao.gif" },
        { name: "不活了", src: "buhuole.gif" },
        { name: "不要", src: "buyao.gif" },
        { name: "超人", src: "chaoren.gif" },
        { name: "大哭", src: "daku.gif" },
        { name: "嗯嗯", src: "enen.gif" },
        { name: "发呆", src: "fadai.gif" },
        { name: "飞呀", src: "feiya.gif" },
        { name: "奋斗", src: "fendou.gif" },
        { name: "尴尬", src: "ganga.gif" },
        { name: "感动", src: "gandong.gif" },
        { name: "害羞", src: "haixiu.gif" },
        { name: "嘿咻", src: "heixiu.gif" },
        { name: "画圈圈", src: "huaquanquan.gif" },
        { name: "惊吓", src: "jinxia.gif" },
        { name: "敬礼", src: "jingli.gif" },
        { name: "快跑", src: "kuaipao.gif" },
        { name: "路过", src: "luguo.gif" },
        { name: "抢劫", src: "qiangjie.gif" },
        { name: "杀气", src: "shaqi.gif" },
        { name: "上吊", src: "shangdiao.gif" },
        { name: "调戏", src: "tiaoxi.gif" },
        { name: "跳舞", src: "tiaowu.gif" },
        { name: "万岁", src: "wanshui.gif" },
        { name: "我走了", src: "wozoule.gif" },
        { name: "喜欢", src: "xihuan.gif" },
        { name: "吓死人", src: "xiasiren.gif" },
        { name: "嚣张", src: "xiaozhang.gif" },
        { name: "疑问", src: "yiwen.gif" },
        { name: "做操", src: "zuocao.gif" }
    ]
</script>
<script src="/static/js/forum/add_upload.js"></script>
<?php useComp('/components/common/footer'); ?>