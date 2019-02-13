    <div class="list-group">
        <a href="/forum/view/?id=<?=$item['id']?>" class="list-item">
            <?php if($item['is_top'] == 1){?> <span style="color:red">[顶]</span><?php }?>
            <?php if($item['is_cream'] == 1){?> <span style="color:red">[精]</span><?php }?>
            <?=$item['title']?>
        </a>
        <div class="bbs_info">
			<div class="flex-box">
            <div class="bbs_user"><img class="bbs_user_photo" src="<?=$item->author['photo']?>" alt=""> <?=$item->author['nickname']?></div>

			<span class="reply_str">
				发布于
			</span>
			<span class="reply_time"><?=$item['create_time']?></span>
			</div>
            <div class="create_time">
                <span class="bbs_replay_num"><i class="icon-svg svg-bbs_reply"></i> <?=$item['reply_count']?> <i class="icon-svg svg-look"></i> <?=$item['read_count']?></span>
            </div>
        </div>
    </div>