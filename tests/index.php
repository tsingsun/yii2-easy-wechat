<?php

// ensure we get report on all possible php errors
//error_reporting(-1);
//define('YII_ENABLE_ERROR_HANDLER', false);
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

$_SERVER['SCRIPT_NAME'] = '/' . __DIR__;
$_SERVER['SCRIPT_FILENAME'] = __FILE__;
if (is_dir(__DIR__ . '/../vendor/')) {
    $vendorRoot = __DIR__ . '/../vendor'; //this extension has its own vendor folder
} else {
    $vendorRoot = __DIR__ . '/../../..'; //this extension is part of a project vendor folder
}
require_once($vendorRoot . '/autoload.php');
require_once($vendorRoot . '/yiisoft/yii2/Yii.php');
Yii::setAlias('@yiiunit/extensions/easyWechat', __DIR__);
Yii::setAlias('@yii/easyWechat', dirname(__DIR__).'/src');
//Yii::setAlias('@app', dirname(__DIR__).'/tests');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../tests/config/main.php'),
    require(__DIR__ . '/../tests/config/main-local.php')
);

$app = new yii\web\Application($config);
$app->run();