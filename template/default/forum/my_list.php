<?php $this->load('/components/common/header', ['title' => '我的帖子']); ?>
<div class="header">
    <span class="back"></span>
    <a href="/user/index" class="left-word">个人中心</a>

    <span class="header-right">
        <a class="icon-svg user" href="/user/index"></a>
    </span>
</div>

<?php $this->load('/components/forum/list', ['list' => $list]); ?>

<?php $this->load('/components/common/footer'); ?>