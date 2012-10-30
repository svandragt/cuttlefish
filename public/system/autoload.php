<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

function carbon_autoloader($class_name) {
	$file = $class_name . '.php';
    require $file;
}

spl_autoload_register('carbon_autoloader');