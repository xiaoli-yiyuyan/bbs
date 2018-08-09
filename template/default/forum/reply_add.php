<?php
    if (!empty($reply_add['err'])) {
        $this->load('/error', ['title' => '回复失败', 'msg' => $reply_add['msg']]);
    } else {
        $this->load('/success', ['title' => '回复成功', 'msg' => '恭喜你成功回复主题！', 'url' => $back_url]);
    }
    // print_r($reply_add);
?>