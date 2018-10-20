<?php

/** @var array $params */

return [
    'class' => 'yii\web\UrlManager',
    'hostInfo' => $params['frontendHostInfo'],
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '' => 'site/index',
        '<_a:about|contact|signup|login|logout>' => 'site/<_a>',

        'blog' => 'blog/post/index',
        'blog/tag/<slug:[\w\-]+>' => 'blog/post/tag',
        'blog/<id:\d+>' => 'blog/post/post',
        'blog/<id:\d+>/comment' => 'blog/post/comment',
        'blog/<slug:[\w\-]+>' => 'blog/post/category',

        'profile' => 'profile/default/index',
        'profile/<_c:[\w\-]+>' => 'profile/<_c>/index',
        'profile/<_c:[\w\-]+>/<id:\d+>' => 'profile/<_c>/view',
        'profile/<_c:[\w\-]+>/<_a:[\w-]+>' => 'profile/<_c>/<_a>',
        'profile/<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => 'profile/<_c>/<_a>',

        '<_c:[\w\-]+>' => '<_c>/index',
        '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
        '<_c:[\w\-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
        '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_c>/<_a>',
    ],
];
