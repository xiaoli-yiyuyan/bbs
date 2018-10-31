<?php return array (
  '/user' => 
  array (
    'index' => 
    array (
      'props' => 
      array (
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'User',
          'action' => 'info',
          'param' => 'userinfo',
          'options' => 
          array (
            'id' => 0,
          ),
        ),
        1 => 
        array (
          'name' => 'User',
          'action' => 'careList',
          'param' => 'care_list',
          'options' => 
          array (
            'user_id' => 0,
            'page' => 1,
            'pagesize' => 10,
            'order' => 0,
            'sort' => 0,
          ),
        ),
        2 => 
        array (
          'name' => 'User',
          'action' => 'fansList',
          'param' => 'fans_list',
          'options' => 
          array (
            'care_user_id' => 0,
            'page' => 1,
            'pagesize' => 10,
            'order' => 0,
            'sort' => 0,
          ),
        ),
      ),
      'template' => 'template\\default/user\\index.php',
    ),
    'edit_info' => 
    array (
      'props' => 
      array (
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'User',
          'action' => 'info',
          'param' => 'userinfo',
          'options' => 
          array (
            'id' => 0,
          ),
        ),
      ),
      'template' => 'template/default/user/edit_info.php',
    ),
    'ajax_edit_info' => 
    array (
      'props' => 
      array (
        'nickname' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
        'explain' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'User',
          'action' => 'editInfo',
          'param' => 'user_edit_info',
          'options' => 
          array (
            'id' => 0,
            'nickname' => 
            array (
              'prop' => 'nickname',
              'value' => '',
            ),
            'explain' => 
            array (
              'prop' => 'explain',
              'value' => '',
            ),
          ),
        ),
      ),
      'template' => 'template/default/user/ajax_edit_info.php',
    ),
    'update_password' => 
    array (
      'props' => 
      array (
      ),
      'source' => 
      array (
      ),
      'template' => 'template/default/user/update_password.php',
    ),
    'ajax_update_password' => 
    array (
      'props' => 
      array (
        'password' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
        'password1' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
        'password2' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'User',
          'action' => 'updatePassword',
          'param' => 'user_edit_pwd',
          'options' => 
          array (
            'id' => 0,
            'password' => 
            array (
              'prop' => 'password',
              'value' => '',
            ),
            'password1' => 
            array (
              'prop' => 'password1',
              'value' => '',
            ),
            'password2' => 
            array (
              'prop' => 'password2',
              'value' => '',
            ),
          ),
        ),
      ),
      'template' => 'template/default/user/ajax_update_password.php',
    ),
    'quit' => 
    array (
      'props' => 
      array (
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'User',
          'action' => 'quit',
          'param' => 'user_quit',
          'options' => 
          array (
          ),
        ),
      ),
      'template' => 'template/default/user/quit.php',
    ),
    'show' => 
    array (
      'props' => 
      array (
        'id' => 
        array (
          'type' => 'get',
          'value' => '',
        ),
        'p1' => 
        array (
          'type' => 'get',
          'value' => '1',
        ),
        'p2' => 
        array (
          'type' => 'get',
          'value' => '1',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'User',
          'action' => 'info',
          'param' => 'userinfo',
          'options' => 
          array (
            'id' => 
            array (
              'prop' => 'id',
              'value' => 0,
            ),
          ),
        ),
        1 => 
        array (
          'name' => 'User',
          'action' => 'isCare',
          'param' => 'is_care',
          'options' => 
          array (
            'care_user_id' => 
            array (
              'prop' => 'id',
              'value' => '',
            ),
          ),
        ),
        2 => 
        array (
          'name' => 'User',
          'action' => 'info',
          'param' => 'user',
          'options' => 
          array (
            'id' => 0,
          ),
        ),
        3 => 
        array (
          'name' => 'Forum',
          'action' => 'list',
          'param' => 'list',
          'options' => 
          array (
            'class_id' => 0,
            'user_id' => 
            array (
              'prop' => 'id',
              'value' => 0,
            ),
            'page' => 
            array (
              'prop' => 'p1',
              'value' => 1,
            ),
            'pagesize' => 10,
            'order' => 0,
            'sort' => 0,
          ),
        ),
        4 => 
        array (
          'name' => 'Forum',
          'action' => 'replyList',
          'param' => 'reply_list',
          'options' => 
          array (
            'forum_id' => 0,
            'user_id' => 
            array (
              'prop' => 'id',
              'value' => 0,
            ),
            'page' => 
            array (
              'prop' => 'p2',
              'value' => 1,
            ),
            'pagesize' => 10,
            'order' => 0,
            'sort' => 0,
          ),
        ),
      ),
      'template' => 'template\\default/user\\show.php',
    ),
    'ajax_base64_upload' => 
    array (
      'props' => 
      array (
        'base64' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'User',
          'action' => 'base64Upload',
          'param' => 'user_base64_upload',
          'options' => 
          array (
            'path' => 'static/uploads/photo/',
            'base64' => 
            array (
              'prop' => 'base64',
              'value' => '',
            ),
          ),
        ),
      ),
      'template' => 'template/default/user/ajax_base64_upload.php',
    ),
    'ajax_care' => 
    array (
      'props' => 
      array (
        'id' => 
        array (
          'type' => 'get',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'User',
          'action' => 'setCare',
          'param' => 'set_care',
          'options' => 
          array (
            'care_user_id' => 
            array (
              'prop' => 'id',
              'value' => '',
            ),
          ),
        ),
      ),
      'template' => 'template\\default/user\\ajax_care.php',
    ),
    'friend' => 
    array (
      'props' => 
      array (
        'id' => 
        array (
          'type' => 'get',
          'value' => '0',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'User',
          'action' => 'careList',
          'param' => 'care_list',
          'options' => 
          array (
            'user_id' => 0,
            'page' => 1,
            'pagesize' => 10,
            'order' => 0,
            'sort' => 0,
          ),
        ),
        1 => 
        array (
          'name' => 'User',
          'action' => 'fansList',
          'param' => 'fans_list',
          'options' => 
          array (
            'care_user_id' => 0,
            'page' => 1,
            'pagesize' => 10,
            'order' => 0,
            'sort' => 0,
          ),
        ),
      ),
      'template' => 'template\\default/user\\friend.php',
    ),
    'message' => 
    array (
      'props' => 
      array (
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'Message',
          'action' => 'list',
          'param' => 'message_list',
          'options' => 
          array (
            'user_id' => 0,
            'to_user_id' => 0,
            'page' => 1,
            'pagesize' => 10,
          ),
        ),
      ),
      'template' => 'template\\default/user\\message.php',
    ),
    'rank' => 
    array (
      'props' => 
      array (
        'type' => 
        array (
          'type' => 'get',
          'value' => '0',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'User',
          'action' => 'list',
          'param' => 'user_list',
          'options' => 
          array (
            'var_page' => 'page',
            'pagesize' => 10,
            'order' => '2',
            'sort' => '1',
          ),
        ),
      ),
      'template' => 'template\\default/user\\rank.php',
    ),
  ),
  '/' => 
  array (
    'index' => 
    array (
      'props' => 
      array (
        'page' => 
        array (
          'type' => 'get',
          'value' => '1',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'Forum',
          'action' => 'list',
          'param' => 'list',
          'options' => 
          array (
            'class_id' => 0,
            'user_id' => 0,
            'page' => 
            array (
              'prop' => 'page',
              'value' => 1,
            ),
            'pagesize' => 10,
            'order' => 0,
            'sort' => '1',
          ),
        ),
        1 => 
        array (
          'name' => 'Forum',
          'action' => 'list',
          'param' => 'list2',
          'options' => 
          array (
            'class_id' => '1',
            'user_id' => 0,
            'page' => 
            array (
              'prop' => 'page',
              'value' => 1,
            ),
            'pagesize' => '2',
            'order' => 0,
            'sort' => '1',
          ),
        ),
        2 => 
        array (
          'name' => 'Column',
          'action' => 'list',
          'param' => 'column_list',
          'options' => 
          array (
            'type' => 0,
            'page' => 1,
            'pagesize' => 10,
            'order' => 0,
            'sort' => 0,
          ),
        ),
        3 => 
        array (
          'name' => 'Message',
          'action' => 'count',
          'param' => 'message_count',
          'options' => 
          array (
            'status' => 0,
          ),
        ),
      ),
      'template' => 'template\\default/\\index.php',
    ),
    'login' => 
    array (
      'props' => 
      array (
      ),
      'source' => 
      array (
      ),
      'template' => 'template/default//login.php',
    ),
    'register' => 
    array (
      'props' => 
      array (
      ),
      'source' => 
      array (
      ),
      'template' => 'template/default//register.php',
    ),
    'error' => 
    array (
      'props' => 
      array (
        'title' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
        'msg' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
      ),
      'template' => 'template\\default/\\error.php',
    ),
    'success' => 
    array (
      'props' => 
      array (
        'title' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
        'msg' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
        'url' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
      ),
      'template' => 'template\\default/\\success.php',
    ),
  ),
  '/components/common' => 
  array (
    'header' => 
    array (
      'props' => 
      array (
        'title' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
        'version' => 
        array (
          'type' => 'value',
          'value' => '0.2.0e',
        ),
      ),
      'source' => 
      array (
      ),
      'template' => 'template\\default/components/common\\header.php',
    ),
    'footer' => 
    array (
      'props' => 
      array (
      ),
      'source' => 
      array (
      ),
      'template' => 'template\\default/components/common\\footer.php',
    ),
    'header_nav' => 
    array (
      'props' => 
      array (
        'back_url' => 
        array (
          'type' => 'value',
          'value' => '#',
        ),
        'title' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'Message',
          'action' => 'count',
          'param' => 'message_count',
          'options' => 
          array (
            'status' => 0,
          ),
        ),
      ),
      'template' => 'template\\default/components/common\\header_nav.php',
    ),
    'page_jump' => 
    array (
      'props' => 
      array (
        'page' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
      ),
      'template' => 'template/default/components/common/page_jump.php',
    ),
    'user_header' => 
    array (
      'props' => 
      array (
        'title' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'Common',
          'action' => 'getUrl',
          'param' => 'get_url',
          'options' => 
          array (
          ),
        ),
      ),
      'template' => 'template/default/components/common/user_header.php',
    ),
    'index_link' => 
    array (
      'props' => 
      array (
      ),
      'source' => 
      array (
      ),
      'template' => 'template\\default/components/common\\index_link.php',
    ),
    'left_menu' => 
    array (
      'props' => 
      array (
      ),
      'source' => 
      array (
      ),
      'template' => 'template\\default/components/common\\left_menu.php',
    ),
  ),
  '/components/forum' => 
  array (
    'list_user' => 
    array (
      'props' => 
      array (
        'user_id' => 
        array (
          'type' => 'value',
          'value' => '0',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'User',
          'action' => 'info',
          'param' => 'userinfo',
          'options' => 
          array (
            'id' => 
            array (
              'prop' => 'user_id',
              'value' => 0,
            ),
          ),
        ),
      ),
      'template' => 'template/default/components/forum/list_user.php',
    ),
    'list' => 
    array (
      'props' => 
      array (
        'list' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
      ),
      'template' => 'template/default/components/forum/list.php',
    ),
    'reply_form' => 
    array (
      'props' => 
      array (
        'forum_id' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'Common',
          'action' => 'getUrl',
          'param' => 'get_url',
          'options' => 
          array (
          ),
        ),
      ),
      'template' => 'template\\default/components/forum\\reply_form.php',
    ),
    'reply_item' => 
    array (
      'props' => 
      array (
        'item' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
      ),
      'template' => 'template/default/components/forum/reply_item.php',
    ),
    'list_item' => 
    array (
      'props' => 
      array (
        'item' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
      ),
      'template' => 'template\\default/components/forum\\list_item.php',
    ),
    'index_count_list' => 
    array (
      'props' => 
      array (
        'class_id' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'Forum',
          'action' => 'list',
          'param' => 'list',
          'options' => 
          array (
            'class_id' => 
            array (
              'prop' => 'class_id',
              'value' => 0,
            ),
            'user_id' => 0,
            'page' => 1,
            'pagesize' => '1',
            'order' => 0,
            'sort' => 0,
          ),
        ),
      ),
      'template' => 'template/default/components/forum/index_count_list.php',
    ),
    'get_count_by_class_id' => 
    array (
      'props' => 
      array (
        'class_id' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'Forum',
          'action' => 'list',
          'param' => 'list',
          'options' => 
          array (
            'class_id' => 
            array (
              'prop' => 'class_id',
              'value' => 0,
            ),
            'user_id' => 0,
            'page' => 1,
            'pagesize' => '1',
            'order' => 0,
            'sort' => 0,
          ),
        ),
      ),
      'template' => 'template/default/components/forum/get_count_by_class_id.php',
    ),
    'upload_json' => 
    array (
      'props' => 
      array (
        'user_id' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
        'file_name' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
        'file_memo' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'File',
          'action' => 'upload',
          'param' => 'file_upload',
          'options' => 
          array (
            'user_id' => 
            array (
              'prop' => 'user_id',
              'value' => 0,
            ),
            'path' => '/upload/forum',
            'size' => '20480000',
            'file_name' => 
            array (
              'prop' => 'file_name',
              'value' => '',
            ),
            'file_memo' => 
            array (
              'prop' => 'file_memo',
              'value' => '',
            ),
            'allow_type' => 'jpeg,jpg,gif,png,rar,zip',
            'is_rand_name' => '1',
            'input_name' => 'file',
          ),
        ),
      ),
      'template' => 'template/default/components/forum/upload_json.php',
    ),
    'reply_list' => 
    array (
      'props' => 
      array (
        'list' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
      ),
      'template' => 'template\\default/components/forum\\reply_list.php',
    ),
    'simple_list' => 
    array (
      'props' => 
      array (
        'list' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
      ),
      'template' => 'template\\default/components/forum\\simple_list.php',
    ),
    'easy_list' => 
    array (
      'props' => 
      array (
        'list' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
      ),
      'template' => 'template\\default/components/forum\\easy_list.php',
    ),
    'easy_list_item' => 
    array (
      'props' => 
      array (
        'item' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
      ),
      'template' => 'template\\default/components/forum\\easy_list_item.php',
    ),
  ),
  '/components/user' => 
  array (
    'new_user_list' => 
    array (
      'props' => 
      array (
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'User',
          'action' => 'list',
          'param' => 'user_list',
          'options' => 
          array (
            'var_page' => 'page',
            'pagesize' => '6',
            'order' => '0',
            'sort' => '1',
          ),
        ),
      ),
      'template' => 'template\\default/components/user\\new_user_list.php',
    ),
    'forum_index_show' => 
    array (
      'props' => 
      array (
        'user_id' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'Forum',
          'action' => 'list',
          'param' => 'bbs',
          'options' => 
          array (
            'class_id' => 0,
            'user_id' => 
            array (
              'prop' => 'user_id',
              'value' => 0,
            ),
            'page' => 1,
            'pagesize' => '1',
            'order' => '1',
            'sort' => 0,
          ),
        ),
      ),
      'template' => 'template/default/components/user/forum_index_show.php',
    ),
    'forum_reply_index_show' => 
    array (
      'props' => 
      array (
        'user_id' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'Forum',
          'action' => 'replyList',
          'param' => 'reply_list',
          'options' => 
          array (
            'forum_id' => 0,
            'user_id' => 
            array (
              'prop' => 'user_id',
              'value' => 0,
            ),
            'page' => 1,
            'pagesize' => 10,
            'order' => 0,
            'sort' => 0,
          ),
        ),
      ),
      'template' => 'template/default/components/user/forum_reply_index_show.php',
    ),
    'is_login' => 
    array (
      'props' => 
      array (
        'back_url' => 
        array (
          'type' => 'get',
          'value' => '/user/index',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'User',
          'action' => 'info',
          'param' => 'userinfo',
          'options' => 
          array (
            'id' => 0,
          ),
        ),
      ),
      'template' => 'template/default/components/user/is_login.php',
    ),
    'friend_list' => 
    array (
      'props' => 
      array (
        'list' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
        'is_fans_care' => 
        array (
          'type' => 'value',
          'value' => 'care',
        ),
      ),
      'source' => 
      array (
      ),
      'template' => 'template\\default/components/user\\friend_list.php',
    ),
    'friend_item_care' => 
    array (
      'props' => 
      array (
        'user_id' => 
        array (
          'type' => 'value',
          'value' => '0',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'User',
          'action' => 'isCare',
          'param' => 'is_care',
          'options' => 
          array (
            'care_user_id' => 
            array (
              'prop' => 'user_id',
              'value' => '',
            ),
          ),
        ),
        1 => 
        array (
          'name' => 'Common',
          'action' => 'getUrl',
          'param' => 'get_url',
          'options' => 
          array (
          ),
        ),
      ),
      'template' => 'template\\default/components/user\\friend_item_care.php',
    ),
    'friend_item' => 
    array (
      'props' => 
      array (
        'user_id' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'User',
          'action' => 'info',
          'param' => 'userinfo',
          'options' => 
          array (
            'id' => 
            array (
              'prop' => 'user_id',
              'value' => 0,
            ),
          ),
        ),
      ),
      'template' => 'template\\default/components/user\\friend_item.php',
    ),
    'message_item' => 
    array (
      'props' => 
      array (
        'user_id' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
        'content' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'User',
          'action' => 'info',
          'param' => 'userinfo',
          'options' => 
          array (
            'id' => 
            array (
              'prop' => 'user_id',
              'value' => 0,
            ),
          ),
        ),
      ),
      'template' => 'template\\default/components/user\\message_item.php',
    ),
    'message_list' => 
    array (
      'props' => 
      array (
        'list' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
      ),
      'template' => 'template\\default/components/user\\message_list.php',
    ),
  ),
  '/login' => 
  array (
    'login' => 
    array (
      'props' => 
      array (
        'username' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
        'password' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
        'back_url' => 
        array (
          'type' => 'get',
          'value' => '/user/index',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'User',
          'action' => 'login',
          'param' => 'user_login',
          'options' => 
          array (
            'username' => 
            array (
              'prop' => 'username',
              'value' => '',
            ),
            'password' => 
            array (
              'prop' => 'password',
              'value' => '',
            ),
          ),
        ),
      ),
      'template' => 'template/default/login/login.php',
    ),
    'register' => 
    array (
      'props' => 
      array (
        'username' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
        'password' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
        'password2' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
        'email' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'User',
          'action' => 'register',
          'param' => 'user_reg',
          'options' => 
          array (
            'username' => 
            array (
              'prop' => 'username',
              'value' => '',
            ),
            'password' => 
            array (
              'prop' => 'password',
              'value' => 10,
            ),
            'password2' => 
            array (
              'prop' => 'password2',
              'value' => 0,
            ),
            'email' => 
            array (
              'prop' => 'email',
              'value' => 0,
            ),
          ),
        ),
      ),
      'template' => 'template\\default/login\\register.php',
    ),
  ),
  '/forum' => 
  array (
    'my_list' => 
    array (
      'props' => 
      array (
        'user_id' => 
        array (
          'type' => 'get',
          'value' => '',
        ),
        'p' => 
        array (
          'type' => 'get',
          'value' => '1',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'Forum',
          'action' => 'list',
          'param' => 'list',
          'options' => 
          array (
            'class_id' => 0,
            'user_id' => 
            array (
              'prop' => 'user_id',
              'value' => 0,
            ),
            'page' => 
            array (
              'prop' => 'p',
              'value' => 1,
            ),
            'pagesize' => 10,
            'order' => 0,
            'sort' => 0,
          ),
        ),
      ),
      'template' => 'template\\default/forum\\my_list.php',
    ),
    'view' => 
    array (
      'props' => 
      array (
        'id' => 
        array (
          'type' => 'get',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'Forum',
          'action' => 'view',
          'param' => 'view',
          'options' => 
          array (
            'id' => 
            array (
              'prop' => 'id',
              'value' => 0,
            ),
            'is_html' => '1',
            'is_ubb' => '1',
          ),
        ),
        1 => 
        array (
          'name' => 'Forum',
          'action' => 'replyList',
          'param' => 'reply_list',
          'options' => 
          array (
            'forum_id' => 
            array (
              'prop' => 'id',
              'value' => 0,
            ),
            'user_id' => 0,
            'page' => 1,
            'pagesize' => 10,
            'order' => 0,
            'sort' => 0,
          ),
        ),
        2 => 
        array (
          'name' => 'User',
          'action' => 'info',
          'param' => 'userinfo',
          'options' => 
          array (
            'id' => 0,
          ),
        ),
      ),
      'template' => 'template\\default/forum\\view.php',
    ),
    'reply' => 
    array (
      'props' => 
      array (
        'id' => 
        array (
          'type' => 'get',
          'value' => '',
        ),
        'p' => 
        array (
          'type' => 'get',
          'value' => '1',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'Forum',
          'action' => 'replyList',
          'param' => 'reply_list',
          'options' => 
          array (
            'forum_id' => 
            array (
              'prop' => 'id',
              'value' => 0,
            ),
            'user_id' => 0,
            'page' => 
            array (
              'prop' => 'p',
              'value' => 1,
            ),
            'pagesize' => 10,
            'order' => 0,
            'sort' => 0,
          ),
        ),
        1 => 
        array (
          'name' => 'Forum',
          'action' => 'view',
          'param' => 'view',
          'options' => 
          array (
            'id' => 
            array (
              'prop' => 'id',
              'value' => 0,
            ),
            'is_html' => 1,
            'is_ubb' => 1,
          ),
        ),
      ),
      'template' => 'template/default/forum/reply.php',
    ),
    'list' => 
    array (
      'props' => 
      array (
        'id' => 
        array (
          'type' => 'get',
          'value' => '0',
        ),
        'p' => 
        array (
          'type' => 'get',
          'value' => '1',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'Forum',
          'action' => 'list',
          'param' => 'list',
          'options' => 
          array (
            'class_id' => 
            array (
              'prop' => 'id',
              'value' => 0,
            ),
            'user_id' => 0,
            'page' => 
            array (
              'prop' => 'p',
              'value' => 1,
            ),
            'pagesize' => 10,
            'order' => 0,
            'sort' => '1',
          ),
        ),
        1 => 
        array (
          'name' => 'Column',
          'action' => 'info',
          'param' => 'column_info',
          'options' => 
          array (
            'id' => 
            array (
              'prop' => 'id',
              'value' => 0,
            ),
          ),
        ),
      ),
      'template' => 'template/default/forum/list.php',
    ),
    'add' => 
    array (
      'props' => 
      array (
        'id' => 
        array (
          'type' => 'get',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'Column',
          'action' => 'info',
          'param' => 'column_info',
          'options' => 
          array (
            'id' => 
            array (
              'prop' => 'id',
              'value' => 0,
            ),
          ),
        ),
      ),
      'template' => 'template/default/forum/add.php',
    ),
    'ajax_upload' => 
    array (
      'props' => 
      array (
        'file_name' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
        'file_memo' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'User',
          'action' => 'info',
          'param' => 'userinfo',
          'options' => 
          array (
            'id' => 0,
          ),
        ),
      ),
      'template' => 'template\\default/forum\\ajax_upload.php',
    ),
    'ajax_add' => 
    array (
      'props' => 
      array (
        'class_id' => 
        array (
          'type' => 'get',
          'value' => '',
        ),
        'title' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
        'context' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
        'img_data' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
        'file_data' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'Forum',
          'action' => 'add',
          'param' => 'forum_add',
          'options' => 
          array (
            'class_id' => 
            array (
              'prop' => 'class_id',
              'value' => 0,
            ),
            'user_id' => 0,
            'title' => 
            array (
              'prop' => 'title',
              'value' => '',
            ),
            'context' => 
            array (
              'prop' => 'context',
              'value' => 10,
            ),
            'img_data' => 
            array (
              'prop' => 'img_data',
              'value' => 0,
            ),
            'file_data' => 
            array (
              'prop' => 'file_data',
              'value' => 0,
            ),
          ),
        ),
      ),
      'template' => 'template/default/forum/ajax_add.php',
    ),
    'reply_add' => 
    array (
      'props' => 
      array (
        'forum_id' => 
        array (
          'type' => 'get',
          'value' => '',
        ),
        'context' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
        'back_url' => 
        array (
          'type' => 'get',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'Forum',
          'action' => 'replyAdd',
          'param' => 'reply_add',
          'options' => 
          array (
            'forum_id' => 
            array (
              'prop' => 'forum_id',
              'value' => 0,
            ),
            'context' => 
            array (
              'prop' => 'context',
              'value' => '',
            ),
          ),
        ),
      ),
      'template' => 'template/default/forum/reply_add.php',
    ),
    'editor' => 
    array (
      'props' => 
      array (
        'id' => 
        array (
          'type' => 'get',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'Forum',
          'action' => 'view',
          'param' => 'view',
          'options' => 
          array (
            'id' => 
            array (
              'prop' => 'id',
              'value' => 0,
            ),
            'is_html' => '0',
            'is_ubb' => '0',
          ),
        ),
      ),
      'template' => 'template\\default/forum\\editor.php',
    ),
    'ajax_edit' => 
    array (
      'props' => 
      array (
        'title' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
        'context' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
        'img_data' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
        'file_data' => 
        array (
          'type' => 'post',
          'value' => '',
        ),
        'id' => 
        array (
          'type' => 'get',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'Forum',
          'action' => 'edit',
          'param' => 'forum_edit',
          'options' => 
          array (
            'id' => 
            array (
              'prop' => 'id',
              'value' => 0,
            ),
            'class_id' => 0,
            'user_id' => 0,
            'title' => 
            array (
              'prop' => 'title',
              'value' => '',
            ),
            'context' => 
            array (
              'prop' => 'context',
              'value' => 10,
            ),
            'img_data' => 
            array (
              'prop' => 'img_data',
              'value' => 0,
            ),
            'file_data' => 
            array (
              'prop' => 'file_data',
              'value' => 0,
            ),
          ),
        ),
      ),
      'template' => 'template/default/forum/ajax_edit.php',
    ),
    'ajax_remove' => 
    array (
      'props' => 
      array (
        'id' => 
        array (
          'type' => 'get',
          'value' => '',
        ),
      ),
      'source' => 
      array (
        0 => 
        array (
          'name' => 'Forum',
          'action' => 'remove',
          'param' => 'forum_remove',
          'options' => 
          array (
            'id' => 
            array (
              'prop' => 'id',
              'value' => 0,
            ),
          ),
        ),
      ),
      'template' => 'template/default/forum/ajax_remove.php',
    ),
  ),
) ?>