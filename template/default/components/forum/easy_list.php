<?php if (!empty($list['data'])) { ?>
<div class="list simple_list">
<?php foreach ($list['data'] as $item) { ?>
<div class="list-group">
        <a href="/forum/view/?id=<?=$item['id']?>" class="list-item">
            <?=$item['title']?>
        </a>
    </div>
<?php } ?>
</div>
<?php } ?>