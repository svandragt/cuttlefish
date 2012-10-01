<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Ext {

	static $register;

	static function environment_start() {
		foreach (Filesystem::list_files( Filesystem::url_to_path('/system/Ext'), 'php') as $key => $value) {
			self::$register[pathinfo($value,PATHINFO_FILENAME)] = true;
			Setup::add_include_path(pathinfo($value,PATHINFO_DIRNAME));	
		}
	}

	static function class_loaded($classname) {
		return isset(self::$register[$classname]);
	}

}