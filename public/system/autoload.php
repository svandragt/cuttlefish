<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * autoload classes on instantiation
 * @param  string $class_name name of class
 */
function carbon_autoloader($class_name) {
	$file = $class_name . '.php';
    require $file;
}

spl_autoload_register('carbon_autoloader');