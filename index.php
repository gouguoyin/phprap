<?php

error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$runtime_dir = __DIR__ . '/runtime';
if(!is_writable($runtime_dir)){
    exit($runtime_dir . '没有可写权限');
}

$db_file = __DIR__ . '/configs/db.php';
if(!is_writable($db_file)){
    exit($db_file . '没有可写权限');
}

defined('YII_DEBUG') or define('YII_DEBUG', true);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
require __DIR__.'/function/function.php';

$config = require __DIR__ . '/configs/web.php';

(new yii\web\Application($config))->run();
