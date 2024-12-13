<?php
/**
 * common.php
 *
 * PHP Version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2024 Blackcube
 * @license https://www.blackcube.io/license license
 * @version XXX
 * @link https://www.blackcube.io
 */

use yii\log\FileTarget;


$config = [
    'sourceLanguage' => 'en',
    'language' => 'en-US',
    'timezone' => 'Europe/Paris',
    'extensions' => require dirname(__DIR__, 2) . '/vendor/yiisoft/extensions.php',
    'basePath' => dirname(__DIR__),
    'aliases' => [
    ],
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'version' => '1.0',
    'bootstrap' => [
        'log',
    ],
    'modules' => [
    ],
    'components' => [
        'cache' => [
            'class' => yii\caching\DummyCache::class,
            // 'class' => yii\caching\DbCache::class,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning', 'profile'],
                ],
            ],
        ],
    ],
    'params' => [
    ],
];


return $config;