<?php
$setting = \comm\Setting::get(['theme', 'component']);
$config = [
    'data_backup_path' => '../data',
    'data_backup_part_size' => 20971520,
    'data_backup_compress' => 1,
    'data_backup_compress_level' => 9,
    'TEMPLATE' => [
        'DIR' => 'theme',
        'PATH' => $setting['theme'].'/template',
        'EXT' => '.php'
    ],
    'REWRITE' => 1, //是否开启伪静态哦 0关闭 1开启
    'component' => $setting['component'],
    'theme' => $setting['theme'],
];
$config = array_merge($config, $setting);
return $config;
