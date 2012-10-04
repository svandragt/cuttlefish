<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Cache {

	static function abort() {
		while (ob_get_level() > 0) {
			ob_end_clean();
		}
	}


	static function start() {
		ob_start();
	}

	static function end() {
		if ( self::has_cacheable_page_request() ) {
			$url = self::cache_file();
			$path = Filesystem::url_to_path("/$url");
			$dirname = pathinfo ($path, PATHINFO_DIRNAME);
			if (!is_dir($dirname)) mkdir ($dirname, 0777, true);
			$fp = fopen($path, 'w'); 
			fwrite($fp, ob_get_contents()); 
			fclose($fp); 
			ob_end_flush();
		}
	}

	static function has_cacheable_page_request() {
		return (!is_null(Carbon::path_info()) && !ob_get_level() == 0 && is_null(error_get_last()));
	}


	static function has_cache() {
		return file_exists(Cache::cache_file()) && Configuration::CACHE_ENABLED;
	}


	static function cache_file() {
		$file_path = substr(Http::server('PATH_INFO'), 1);
		$filename =  pathinfo ( $file_path , PATHINFO_DIRNAME  ) .'/'. pathinfo ( $file_path , PATHINFO_FILENAME );
		$ext = pathinfo ( $file_path , PATHINFO_EXTENSION);
		if (strrpos($file_path, '.') === false) {
			$filename = rtrim($filename,'/'). '/index';
			$ext = 'html';

			if (!strrpos($filename, 'feed') === false) $ext = 'xml';
		} 




		return sprintf( "%s/%s.%s", Configuration::CACHE_FOLDER, ltrim($filename, '/'), $ext);
	}

	static function clear() {
		Security::login_redirect();
		$dir =  BASEPATH . DIRECTORY_SEPARATOR . str_replace("/", DIRECTORY_SEPARATOR, Configuration::CACHE_FOLDER);
		printf("Removing  all files in %s<br>", $dir);
		FileSystem::remove_files($dir,true);
		Filesystem::ensure_folder_exists( Configuration::CACHE_FOLDER );			
	}

	static function generate_site() {
		Security::login_redirect();
		echo "<br>Generating site:<br>". PHP_EOL;
		$content = Configuration::CONTENT_FOLDER;
		$ext     = Configuration::CONTENT_EXT;
		$c       = new Curl;
		$files   = array();
		$files[] = Filesystem::url_to_path("/". Configuration::CONTENT_FOLDER . "/"); // hack to get index.php
		foreach (Filesystem::list_files( Filesystem::url_to_path("/$content"), $ext ) as $key => $value) {
			$files[] = $value;
		}
		foreach ($files as $key => $value) {
			echo "$key: $value<br>";
			$url = Theming::root() . Theming::content_url($value);
			echo "$url<br>" . PHP_EOL;
			$c->url_contents($url); 
		}
		$c->close();
	}
}