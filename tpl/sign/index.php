<?php self::load('common/header',['title' => '每日签到']); ?>
<?php self::load('common/header_nav',['title' => '每日签到', 'back_url' => '/','message_count' => 0]); ?>
<div>
    <div class="sign_input_box">
        <div class="sign_word flex-box">
            <div>
                <div class="feel feel_0">求好运</div>
            </div>
            <div>
                <div class="feel feel_1">开心</div>
            </div>
            <div>
                <div class="feel feel_2">难过</div>
            </div>
            <div>
                <div class="feel feel_3">元气</div>
            </div>
            <div>
                <div class="feel feel_4">难受</div>
            </div>
            <div>
                <div class="feel feel_5">努力</div>
            </div>
            <div>
                <div class="feel feel_6">划水</div>
            </div>
            <div>
                <div class="feel feel_7">奋斗</div>
            </div>
            <div>
                <div class="feel feel_8">大家好</div>
            </div>
            <div>
                <div class="feel feel_9">生气ing</div>
            </div>
        </div>
        <div class="input-search">
            <input type="text" class="input" placeholder="请输入关键字">
            <span class="btn btn-fill">签到</span>
        </div>
    </div>
    <div>
        <div class="nav_title">签到奖励说明</div>
        <div>
        不连续第一次奖励 1，连续签到奖励递加 1，最大上限为 7<br>
        VIP1每日签到额外奖励 1<br>
        VIP2每日签到额外奖励 2<br>
        VIP3每日签到额外奖励 3<br>
        VIP4每日签到额外奖励 4<br>
        VIP5每日签到额外奖励 5<br>
        随机奖励：有一定的几率额外获得 1 - 20 的额外金币奖励，100 - 1000额外经验奖励<br>
        暴击：有一定的几率产生暴击，获得双倍奖励<br>
        </div>
    </div>
</div>
<?php self::load('common/footer'); ?>
