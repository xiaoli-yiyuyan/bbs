<?php component('/components/common/user_header', ['title' => '帖子发布']); ?>
<?php component('/components/common/header_nav', ['title' => '内容发布']); ?>
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
<form id="add" class="box-padding" action="/forum/ajax_add" method="post">
    <input type="hidden" name="img_data">
    <input type="hidden" name="file_data">
    


    <?php $column = source('App/Column/list'); ?>
    
    <div class="item-line item-lg">
        <div class="item-title">分类</div>
        <div class="item-input">
            <select class="input input-line input-lg" name="class_id" id="">
                <option>请选择分类</option>

            <?php foreach ($column as $item) { ?>
                <option value="<?=$item['id']?>" <?=(!empty($column_info) && $column_info['id'] == $item['id']) ? 'selected="selected"' : ''?>><?=$item['title']?></option>
            <?php } ?>
            </select>
        </div>
    </div>

    <div class="item-line item-lg">
        <div class="item-title">标题</div>
        <div class="item-input"><input type="text" class="input input-line input-lg" name="title" placeholder="标题"></div>
    </div>
    <div class="item-line item-lg">
        <div class="item-title">内容</div>
        <div class="item-input">
            <textarea name="context" class="add_context input input-line input-lg" placeholder="简介"></textarea>
        </div>
    </div>
    <div class="file_box">
        <div class="tab">
            <div class="tab-header">
                <div class="tab-link tab-active" data-to-tab=".tab1">图片</div>
                <div class="tab-link" data-to-tab=".tab2">文件</div>
            </div>
            <div class="tab-content">
                <div class="tab-page tab1 tab-active">
                    <div class="file_group">
                        <div class="add_btn add_img">
                            添加<br>图片
                        </div>
                    </div>
                </div>
                <div class="tab-page tab2">
                    <div class="file_group">
                        <div class="add_btn add_file">
                            添加<br>文件
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="mark_body">
    <div class="item-line item-lg">
        <div class="item-title">标签</div>
        <div class="item-input">
        <div class="input mark_input btn-sm" contenteditable="true"></div><span class="btn_add_mark">添加</span>
        </div>
    </div>
    <p><button class="btn btn-fill btn-lg btn-block">立即发表</button></p>
</form>
<script>
</script>
<!-- 代码自定义 BEGIN -->
<?=code('forum_ubb')?>
<!-- 代码自定义 END -->
<script src="/static/js/forum/add_upload.js"></script>
<?php component('/components/common/footer'); ?>