<?php
/**
 * main.php
 *
 * PHP Version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2024 Blackcube
 * @license https://www.blackcube.io/license license
 * @version XXX
 * @link https://www.blackcube.io
 * @package webapp\config
 */

use yii\web\AssetManager;
use yii\web\JsonParser;

$config = require 'common.php';

$config['id'] = 'blackcube/mailjet';
$config['name'] = 'Blackcube.io Mailjet test application';


return $config;
