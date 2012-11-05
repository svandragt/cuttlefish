<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Environment {

	protected $register;

	public function __construct() {
		Log::debug(__FUNCTION__ . " called.");

		$this->add_include_path(Filesystem::url_to_path('/'.Configuration::APPLICATION_FOLDER));	
		define('THEME_DIR', DIRECTORY_SEPARATOR . Configuration::THEMES_FOLDER . DIRECTORY_SEPARATOR . Configuration::THEME . DIRECTORY_SEPARATOR);
		if ( $this->new_install()) {
			Filesystem::ensure_folder_exists( Configuration::LOGS_FOLDER );
			Filesystem::ensure_folder_exists( Configuration::CACHE_FOLDER );
			Filesystem::ensure_folder_exists( Configuration::CONTENT_FOLDER . '/pages');
			Filesystem::ensure_folder_exists( Configuration::CONTENT_FOLDER . '/posts');
			Filesystem::ensure_folder_exists( Configuration::CONTENT_FOLDER . '/errors');
			Filesystem::ensure_folder_exists( Configuration::THEMES_FOLDER);
			$this->webserver_configuration();
		}

		// Externals environment
		$flist = new Files(array('url' => '/system/Ext'), 'php');
		foreach ($flist->collection as $key => $value) {
			$this->register[pathinfo($value,PATHINFO_FILENAME)] = true;
			$this->add_include_path(pathinfo($value,PATHINFO_DIRNAME));	
		}
		session_start();
	}

	public function __destruct() {
	}


	public function class_loaded($classname) {
		return isset($this->register[$classname]);
	}



	private function new_install() {
		Log::debug(__FUNCTION__ . " called.");
		return !(is_dir( Configuration::CACHE_FOLDER ) && is_dir( Configuration::CONTENT_FOLDER )) ;
	}

	function add_include_path($path) {
		Log::debug(__FUNCTION__ . " called.");
		set_include_path(get_include_path() . PATH_SEPARATOR . realpath($path));
	}

	function webserver_configuration() {
		Log::debug(__FUNCTION__ . " called.");
		$directory_index = "index.html index.xml";
		$path = Configuration::CACHE_FOLDER . DIRECTORY_SEPARATOR . ".htaccess";
		$fp = fopen($path, 'w'); 
		fwrite($fp, "DirectoryIndex  $directory_index\n"); 
		fwrite($fp, "ErrorDocument 404 /errors/404/\n"); 
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