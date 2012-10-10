<?php
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);
$dir = realpath(dirname(__FILE__));

spl_autoload_register('carbon_autoloader');


defined('BASEPATH') OR define('BASEPATH', realpath($dir.'/../public'));

isset($_SERVER['PATH_INFO']) OR $_SERVER['PATH_INFO'] = '/';

set_include_path(get_include_path() . PATH_SEPARATOR . realpath(BASEPATH));

unset($dir);

function carbon_autoloader($class_name) {
	require($class_name.'.php');
}
