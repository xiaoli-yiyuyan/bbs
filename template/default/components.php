<?php return array (
  '/' => 
  array (
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
        'keywords' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
        'description' => 
        array (
          'type' => 'value',
          'value' => '',
        ),
      ),
      'source' => 
      array (
      ),
      'template' => 'template/default/components/common/header.php',
    ),
    'footer' => 
    array (
      'props' => 
      array (
      ),
      'source' => 
      array (
      ),
      'template' => 'template/default/components/common/footer.php',
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
      ),
      'template' => 'template/default/components/common/header_nav.php',
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
      'template' => 'template/default/components/common/index_link.php',
    ),
    'left_menu' => 
    array (
      'props' => 
      array (
      ),
      'source' => 
      array (
      ),
      'template' => 'template/default/components/common/left_menu.php',
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
      'template' => 'template/default/components/forum/reply_form.php',
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
      'template' => 'template/default/components/forum/list_item.php',
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
      'template' => 'template/default/components/forum/reply_list.php',
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
      'template' => 'template/default/components/forum/simple_list.php',
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
      'template' => 'template/default/components/forum/easy_list.php',
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
      'template' => 'template/default/components/forum/easy_list_item.php',
    ),
    'img_list' => 
    array (
      'props' => 
      array (
      ),
      'source' => 
      array (
      ),
      'template' => 'template/default/components/forum/img_list.php',
    ),
    'img_list_item' => 
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
      'template' => 'template/default/components/forum/img_list_item.php',
    ),
    'list_img_text' => 
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
      'template' => 'template/default/components/forum/list_img_text.php',
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
      'template' => 'template/default/components/user/new_user_list.php',
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
      'template' => 'template/default/components/user/friend_list.php',
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
      'template' => 'template/default/components/user/friend_item_care.php',
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
      'template' => 'template/default/components/user/friend_item.php',
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
      'template' => 'template/default/components/user/message_item.php',
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
      'template' => 'template/default/components/user/message_list.php',
    ),
  ),
  '/asdasdasd' => 
  array (
    'asdsadasd' => 
    array (
      'props' => 
      array (
      ),
      'source' => 
      array (
      ),
      'template' => 'template/default/asdasdasd/asdsadasd.php',
    ),
  ),
) ?>