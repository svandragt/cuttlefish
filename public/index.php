<?php
define('BASE_FILEPATH', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . '/');
define('BASE_PATH', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
$loader = require '../vendor/autoload.php';
$loader->add('', __DIR__.'/');
$loader->add('', __DIR__.'/system/');
$carbon = new Request();
