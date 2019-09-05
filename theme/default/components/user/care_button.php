<?php if ($user_id == 0 || $user_id == $care_user_id) return; ?>

<?php if (source('/Model/Friend/isCare', [ 'user_id' => $user_id, 'care_user_id' => $care_user_id ])) { ?>
    <button data-user-id="<?=$care_user_id?>" class="btn btn-sm btn-action-care">- 已关</button>
<?php } else { ?>
    <button data-user-id="<?=$care_user_id?>" class="btn btn-fill btn-sm btn-action-care">+ 关注</button>
<?php } ?>