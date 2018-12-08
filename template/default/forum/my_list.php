<?php $this->load('/components/common/header', ['title' => '我的帖子']); ?>
<?php $this->load('/components/common/header_nav', ['back_url' => '/user/index', 'title' => '个人中心']); ?>

<?php $this->load('/components/forum/list', ['list' => $list]); ?>

<?php $this->load('/components/common/footer'); ?>