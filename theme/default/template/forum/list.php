<?php useComp('/components/common/header?title=' . $class_info['title'] . "-论坛中心"); ?>
<?php useComp('/components/common/header_nav', [
    'title' => $class_info['title']
]); ?>
<div class="bbas_action">
    <div class="create_time">发帖 <?=$list->total()?> 篇</div>
    <div class="create_time reply">有<?=$reply_count?>人评论</div>
</div>

<a class="add-bbs" href="/forum/add_page?class_id=<?=$class_info['id']?>" style="display:inline-block;">发帖</a>

<div class="_index_nav">
    <div <?=$order == 1 && $type == 0 ? 'class="_active"' : ''?>>
        <a unhistory href="/forum/list?id=<?=$class_info['id']?>&order=1">推荐</a>
    </div>
    <div <?=$order == 2 && $type == 0 ? 'class="_active"' : ''?>>
        <a unhistory href="/forum/list?id=<?=$class_info['id']?>&order=2">最新</a>
    </div>
    <div <?=$type == 2 ? 'class="_active"' : ''?>>
        <a unhistory href="/forum/list?id=<?=$class_info['id']?>&type=2">话题</a>
    </div>
    <div <?=$type == 3 ? 'class="_active"' : ''?>>
        <a unhistory href="/forum/list?id=<?=$class_info['id']?>&type=3">图片</a>
    </div>
    <div <?=$type == 4 ? 'class="_active"' : ''?>>
        <a unhistory href="/forum/list?id=<?=$class_info['id']?>&type=4">文件</a>
    </div>
</div>

<!-- <div class="bbs_order border-b">
    <div class="bbs_order_title">最近回复</div>
    <div>·</div>
</div> -->
<?php if ($list->total() == 0) { ?>
    <div class="bbs_empty">这个地方空空如也！</div>
<?php } else { ?>
    <div class="list bbs_list">
<?php foreach($list as $item) { ?>
    <?php useComp('/components/forum/list_care', ['item' => $item]); ?>
<?php } ?>
</div>

<!-- 分页 -->
<?=$list->render([
    'id' => $class_info['id'],
    'order' => $order,
    'type' => $type,
])?>
</div>
<script>

var fnUrlReplace = function (eleLink) {
		if (!eleLink) {
			return;
		}
		var href = eleLink.href;
		if (href && /^#|javasc/.test(href) === false) {
            if (history.replaceState) {
            	history.replaceState(null, document.title, href.split('#')[0] + '#');
                location.replace('');
            } else {
             	location.replace(href);
            }
        }
	};
    $('a[unhistory]').click(function(event) {
        
		if (event && event.preventDefault) {
			event.preventDefault();
        }
		fnUrlReplace(this);
		return false;
    });
	// document.getElementsByTagName('a').onclick = function (event) {
	// 	if (event && event.preventDefault) {
	// 		event.preventDefault();
    //     }
	// 	fnUrlReplace(this);
	// 	return false;
	// };

</script>
<?php } ?>
<?php useComp('/components/common/footer'); ?>