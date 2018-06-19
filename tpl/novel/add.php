<?php self::load('Common/header',['title' => '添加文章']); ?>
<div class="header">
    <span class="back"></span>
    <span class="header-center">添加小说</span>
</div>

<style media="screen">
    .mark-out {
        padding-right: .5rem;
    }
    .mark-name{
        display: none;
    }
    .add-mark-show{
        display: inline-block;
    }
</style>
<form class="box-padding" action="/Novel/add" method="post">

    <div class="item-line item-lg">
        <div class="item-title">标题</div>
        <div class="item-input"><input type="text" class="input input-line input-lg" name="title" placeholder="标题"></div>
    </div>
    
    <div class="item-line item-lg">
        <div class="item-title">封面</div>
        <div class="item-input"><input type="text" class="input input-line input-lg" name="photo" placeholder="封面"></div>
    </div>
    
    <div class="item-line item-lg">
        <div class="item-title">作者</div>
        <div class="item-input"><input type="text" class="input input-line input-lg" name="author" placeholder="作者"></div>
    </div>
    
    <div class="item-line item-lg mark-out">
        <div class="item-title">标签</div>
        <div class="item-input">
            <span class="mark-box"></span>
            <input type="text" name="marktitle" class="mark-name input">
            <button type="button" class="btn add-mark">添加</button>
        </div>
    </div>

    
    <div class="item-line item-lg">
        <div class="item-title">字数</div>
        <div class="item-input"><input type="text" class="input input-line input-lg" name="wordcount" placeholder="字数"></div>
    </div>
    

    <div class="item-line item-lg">
        <div class="item-title">简介</div>
        <div class="item-input">
            <textarea name="memo" class="input input-line input-lg" placeholder="简介"></textarea>
        </div>
    </div>
    <p><button class="btn btn-fill btn-lg">立即添加</button></p>
</form>

    <script type="text/javascript">
        var markList = function()
        {
            $.get('/Novel/mark', function(data) {
                $('.mark-box').html('');
                for(var value of data) {
                    console.log(value);
                    $('.mark-box').append('<input type="checkbox" name="mark[]" value="' + value.id + '" />' + value.title);
                }
            }, 'json');
        }
        markList();

        var $mark_name = $('.mark-name');
        $('.add-mark').click(function() {
            if ($mark_name.hasClass('add-mark-show')) {
                //添加mark
                $('.mark-name').removeClass('add-mark-show');
                var mark_title = $mark_name.val();
                if (mark_title) {
                    $.post('/Novel/addMark', {
                        'title': mark_title
                    }, function(data) {
                        if (!data.err){
                            markList();
                        }
                        alert(data.msg);
                    }, 'json');
                }
            } else {
                $('.mark-name').addClass('add-mark-show');
            }
        });
    </script>
<?php self::load('Common/footer'); ?>
