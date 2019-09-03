<?php

$params = require __DIR__ . '/params.php';

$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'charset'  => 'utf-8',
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'components' => [
        'request' => [
            'cookieValidationKey' => 'cookie-phprap',
            'csrfParam' => 'csrf-phprap',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Account',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => 'identity-phprap', 'httpOnly' => true],
            'loginUrl'=>['account/login']
        ],
        'view' => [
            'defaultExtension' => 'html',
            'renderers' => [
                'html' => [
                    'class' => 'yii\smarty\ViewRenderer',
                    'cachePath' => '@runtime/smarty/cache',
                    'compilePath' => '@runtime/smarty/compile',
                    'options' => [
                        'left_delimiter' => '{{',
                        'right_delimiter' => '}}',
                    ],
                    'pluginDirs' => ['@app/plugins/smarty'],
                ],
            ],

        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'  => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '.html',
            'rules' => [
                '/' => '/home/site/index',
                '/project/<id:\d+>' => 'home/project/show',
                '/member/<id:\d+>' => 'home/member/show',
                '/api/<id:\d+>' => 'home/api/show',
                '/admin/home' => '/admin/home/index',
                "<controller:\w+>/<action:\w+>"=>"home/<controller>/<action>",
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
//        'allowedIPs' => ['101.200.46.207', '::1', '192.168.200.106'],
    ];
}

return $config;
