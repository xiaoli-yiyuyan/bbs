<?php
if ($user_reg['err']) {
    $this->load('/error', ['title' => '注册失败', 'msg' => $user_reg['msg']]);
} else {
    $this->load('/success', ['title' => '注册成功', 'msg' => '恭喜你成功注册！', 'url' => '/user/index']);
}
?>