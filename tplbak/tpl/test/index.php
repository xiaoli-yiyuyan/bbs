<?php self::load('common/header', ['title' => '安米小说']); ?>

<?php
$data = [
    'name' => 'foot',
    'path' => 'common/footer'
];
$options = [
    'template' => $data['path'],
    'props' => ['id' => 1],
    'data' => function($options) {
        $data = [
            'ids' => $options['props']['id']
        ];
        $forum = new \Model\Forum;
        $_options = $options['data']['options'];
        $data['list'] = $forum->list($options['props']['options']);
        return $data;
    }
];
self::component($data['name'], $options);
self::loadComponent($data['name'], ['id' => 444]);
?>