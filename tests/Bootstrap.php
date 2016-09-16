<?php
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);
$dir = realpath(dirname(__FILE__));


defined('BASE_FILEPATH') OR define('BASE_FILEPATH', realpath($dir.'/../public'));

isset($_SERVER['PATH_INFO']) OR $_SERVER['PATH_INFO'] = '/';

set_include_path(get_include_path() . PATH_SEPARATOR . realpath(BASE_FILEPATH));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath(BASE_FILEPATH. '/system'));

include BASE_FILEPATH . '/system/autoload.php';

unset($dir);
