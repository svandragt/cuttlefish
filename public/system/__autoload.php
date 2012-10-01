<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

function __autoload($class_name) {
	require($class_name.'.php');
} 
