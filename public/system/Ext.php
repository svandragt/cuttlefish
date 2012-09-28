<?php

class Ext {

	static function environment_start() {
		foreach (Filesystem::list_files( Filesystem::url_to_path('/system/Ext'), 'php') as $key => $value) {

			self::add_include_path(pathinfo($value,PATHINFO_DIRNAME));	
		}
	}

	static function add_include_path($path) {
		set_include_path(get_include_path() . PATH_SEPARATOR . realpath($path));
	}

}