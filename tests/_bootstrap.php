<?php
// This is global bootstrap for autoloading
date_default_timezone_set('Europe/Paris');

// ensure we get report on all possible php errors
error_reporting(E_ALL);
define('YII_ENABLE_ERROR_HANDLER', false);
define('YII_DEBUG', true);
$_SERVER['SCRIPT_NAME'] = '/' . __DIR__;
$_SERVER['SCRIPT_FILENAME'] = __FILE__;
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

define('MAILJET_FROM', '<sender>');
define('MAILJET_KEY', '<key>');
define('MAILJET_SECRET', '<secret>');
define('MAILJET_TO', '<target>');
define('MAILJET_TEMPLATE', 218932);
define('MAILJET_TEST_SEND', false);

define('POSTMARK_FROM', '<sender>');
define('POSTMARK_TOKEN', '<token>');
define('POSTMARK_TO', '<target>');
define('POSTMARK_TEMPLATE', 218932);
define('POSTMARK_TEST_SEND', false);

define('SENDGRID_FROM', '<sender>');
define('SENDGRID_KEY', '<key>');
define('SENDGRID_TO', '<target>');
define('SENDGRID_TEMPLATE', 'd-xxxxxx');
define('SENDGRID_TEST_SEND', false);

Yii::setAlias('@tests/mailjet', __DIR__ . '/mailjet');
Yii::setAlias('@tests/postmark', __DIR__ . '/postmark');
Yii::setAlias('@tests/sendgrid', __DIR__ . '/sendgrid');
Yii::setAlias('@blackcube/mailer', dirname(__DIR__) . '/src');