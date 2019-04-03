<div class="left-menu-list">
    <div class="modal-overlay"></div>
    <div class="menu-list-body">
        <div class="left_user_box border-b">
            
        <?php if ($user['id'] > 0) { ?>
            <div class="user-info">
                <img class="user-photo photo" src="<?=$user['photo']?>" alt="">
            </div>
            
            <div class="info-box">
                <div class="user-nc">
                    <span><?=$user['nickname']?> <span class="vip_icon vip_0">vip <?=$user['vip_level']?></span></span>
                </div>
                <div class="user-ep">
                    <span class="user_lv">等级：<?=$user['level']?></span><span class="user_coin">金币: <?=$user['coin']?></span>
                </div>
            </div>
            <a class="fans_nav flex-box" href="/user/friend_care">
                <div class="fans_nav_link">
                    <div class="fans_nav_num"><?//=$care_count?></div>
                    <div>关注</div>
                </div>
                <div class="fans_nav_link border-l">
                    <div class="fans_nav_num"><?//=$fans_count?></div>
                    <div>粉丝</div>
                </div>
            </a>
        <?php } else { ?>
            <a href="<?=href('/login')?>">
                <div class="user-info">
                    <img class="user-photo photo" src="" alt="">
                </div>
                <div class="info-box">
                    <div class="user-nc">登录/注册</div>
                </div>
            </a>
        <?php } ?>
        </div>
        <div class="list">
            <div class="list-group list-arrow">
                <!-- <a href="/" class="list-item ellipsis">社区首页</a>
                <a href="/user/index" class="list-item ellipsis">个人中心</a>
                <a href="/user/friend" class="list-item ellipsis">我的好友</a> -->
                <!-- <div class="list-item ellipsis">消息列表</div>
                <div class="list-item ellipsis">论坛大厅</div> -->
                <?php $column = source('App/Column/list'); ?>
                <?php foreach ($column as $item) { ?>
                <a class="list-item ellipsis list-item-icon" href="<?=href('/forum/list?id=' . $item['id'])?>">
                    <img src="<?=$item['photo']?>" alt="<?=$item['title']?>">
                    <?=$item['title']?> [<?=$item->getTotal()?>]
                </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>