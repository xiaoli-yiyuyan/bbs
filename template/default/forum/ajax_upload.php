<?php
	if (!$userinfo['id']) {
 		return;
    }
	$this->load('components/forum/upload_json', [
    'user_id' => $userinfo['id']]);
?>