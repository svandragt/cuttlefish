<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Setup {

	static public function environment_start() {
		self::add_include_path(Filesystem::url_to_path('/'.Configuration::APPLICATION_FOLDER));	
		define('THEME_DIR', DIRECTORY_SEPARATOR . Configuration::THEMES_FOLDER . DIRECTORY_SEPARATOR . Configuration::THEME . DIRECTORY_SEPARATOR);
		if ( self::new_install()) {
			Filesystem::ensure_folder_exists( Configuration::LOGS_FOLDER );
			Filesystem::ensure_folder_exists( Configuration::CACHE_FOLDER );
			Filesystem::ensure_folder_exists( Configuration::CONTENT_FOLDER . '/pages');
			Filesystem::ensure_folder_exists( Configuration::CONTENT_FOLDER . '/posts');
			Filesystem::ensure_folder_exists( Configuration::CONTENT_FOLDER . '/errors');
			Filesystem::ensure_folder_exists( Configuration::THEMES_FOLDER);
			self::webserver();
		}

		Ext::environment_start();
		session_start();
	}

	static public function environment_end() {
	}

	static private function new_install() {
		return !(is_dir( Configuration::CACHE_FOLDER ) && is_dir( Configuration::CONTENT_FOLDER )) ;
	}

	static function add_include_path($path) {
		set_include_path(get_include_path() . PATH_SEPARATOR . realpath($path));
	}

	static function webserver() {
		$directory_index = "index.html index.xml";
		$path = Configuration::CACHE_FOLDER . DIRECTORY_SEPARATOR . ".htaccess";
		$fp = fopen($path, 'w'); 
		fwrite($fp, "DirectoryIndex  $directory_index"); 
		fclose($fp); 


		$path = Configuration::CACHE_FOLDER . DIRECTORY_SEPARATOR . "web.config";
        $xml = new SimpleXMLElement('<configuration></configuration>'); 
        $sys = $xml->addChild('system.webServer'); 
        $sys->addChild('defaultDocument'); 
        $files = $sys->defaultDocument->addChild('files'); 
        $files->addChild('clear'); 
        $values = explode(' ', $directory_index);
        foreach ($values as $value) {
    		$add = $files->addChild('add'); 
	        $add->addAttribute('value', $value);
        }
        $xml->asXML($path);
	}

}