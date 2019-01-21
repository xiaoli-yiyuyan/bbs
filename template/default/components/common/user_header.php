<?php
    if (!source('App/Common/isLogin')) {
        redirect('/login', ['back_url' => $get_url]);
    }
    $this->load('/components/common/header', ['title' => $title]);
?>