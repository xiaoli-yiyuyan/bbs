<?php $this->load('components/common/user_header',['title' => '消息列表']); ?>
<?php $this->load('/components/common/header_nav', ['back_url' => '/user/index', 'title' => '个人中心']); ?>

<?php $this->load('components/user/message_list', ['list' => $message_list]); ?>
<?php $this->load('components/common/footer'); ?>
