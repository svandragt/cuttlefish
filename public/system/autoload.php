<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

function carbon_autoloader($class_name) {
	require($class_name.'.php');
}

spl_autoload_register('carbon_autoloader');
