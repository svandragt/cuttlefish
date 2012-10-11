<?php
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);
$dir = realpath(dirname(__FILE__));


defined('BASEPATH') OR define('BASEPATH', realpath($dir.'/../public'));

isset($_SERVER['PATH_INFO']) OR $_SERVER['PATH_INFO'] = '/';

set_include_path(get_include_path() . PATH_SEPARATOR . realpath(BASEPATH));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath(BASEPATH. '/system'));

include BASEPATH . '/system/autoload.php';

unset($dir);
