<?php
if (!empty($user_login['err'])) {
    $this->load('/error', ['title' => '登录失败', 'msg' => $user_login['msg']]);
} else {
    $this->load('/success', ['title' => '登录成功', 'msg' => '恭喜你成功登录！', 'url' => $back_url]);
}
?>