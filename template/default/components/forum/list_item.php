    <div class="list-group">
        <a href="/forum/view/?id=<?=$item['id']?>" class="list-item">
            <?=$item['title']?>
        </a>
        <div class="bbs_info border-t">
            <?php $this->load('/components/forum/list_user', ['user_id' => $item['user_id']]); ?>
            <div class="create_time">
                <span class="bbs_replay_num"><?=$item['reply_count']?>回/<?=$item['read_count']?>逛</span>
                <?=$item['create_time']?>
            </div>
        </div>
    </div>