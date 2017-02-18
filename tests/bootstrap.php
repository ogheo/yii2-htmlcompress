<?php
// ensure we get report on all possible php errors
define('YII_ENABLE_ERROR_HANDLER', false);
define('YII_DEBUG', true);

error_reporting(-1);

$_SERVER['SCRIPT_NAME'] = '/' . __DIR__;
$_SERVER['SCRIPT_FILENAME'] = __FILE__;
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

Yii::setAlias('@smilemdunit/htmlcompress', __DIR__);
Yii::setAlias('@smilemd/htmlcompress', dirname(__DIR__));