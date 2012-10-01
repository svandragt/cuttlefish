<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Setup {

	static public function environment_start() {
		define('THEME_DIR', DIRECTORY_SEPARATOR . Configuration::THEMES_FOLDER . DIRECTORY_SEPARATOR . Configuration::THEME . DIRECTORY_SEPARATOR);
		if ( self::new_install()) {
			Filesystem::ensure_folder_exists( Configuration::LOGS_FOLDER );
			Filesystem::ensure_folder_exists( Configuration::CACHE_FOLDER );
			Filesystem::ensure_folder_exists( Configuration::CONTENT_FOLDER . '/pages');
			Filesystem::ensure_folder_exists( Configuration::CONTENT_FOLDER . '/posts');
			Filesystem::ensure_folder_exists( Configuration::THEMES_FOLDER);
		}

		Ext::environment_start();
	}

	static public function environment_end() {
	}

	static private function new_install() {
		return !(is_dir( Configuration::CACHE_FOLDER ) && is_dir( Configuration::CONTENT_FOLDER )) ;
	}
}