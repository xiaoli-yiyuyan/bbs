<div class="card img_bbs_list_item">

        <a href="/forum/view/?id=<?=$item['id']?>">
        <div class="">
            <?php if (!empty($item['img_list'])) { ?>
            <div class="img_flex_box">
                <?php for($i = 0; $i < count($item['img_list']) && $i < 3; $i ++) { ?>
                    <div class="img_bx"><img src="/forum/imagecropper/?path=.<?=$item['img_list'][$i]['path']?>" alt=""></div>
                <?php } ?>
            </div>
            <?php } ?>
            <?=$item['title']?>
            </div>
        </a>
        <div class="bbs_info">
			<div class="flex-box">
            <?php $this->load('/components/forum/list_user', ['user_id' => $item['user_id']]); ?>
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