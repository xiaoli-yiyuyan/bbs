<?php
	if (!$userinfo['id']) {
 		return;
    }
	$this->load('components/forum/upload_json', [
    'user_id' => $userinfo['id'], 'file_name' => $file_name, 'file_memo' => $file_memo]);
?>