<?php

class Cache {

	static function start() {
		if (!ob_get_level()) ob_start();
	}

	static function end() {
		if ( self::has_cacheable_page_request() ) {
			$fp = fopen(self::cache_file(), 'w'); 
			fwrite($fp, ob_get_contents()); 
			fclose($fp); 
			ob_end_flush();
		}
	}

	static function has_cacheable_page_request() {
		return (!is_null(Http::server('PATH_INFO')) && !ob_get_level() == 0 && is_null(error_get_last()));
	}


	static function has_cache() {
		return file_exists(Cache::cache_file()) && Configuration::CACHE_ENABLED;
	}


	static function cache_file() {
		return sprintf( "%s/%s.html", Configuration::CACHE_FOLDER, str_replace("/", "_", substr(Http::server('PATH_INFO'), 1)));
	}

	static function clear() {
		$glob_dir =  BASEPATH . DIRECTORY_SEPARATOR . str_replace("/", DIRECTORY_SEPARATOR, Configuration::CACHE_FOLDER) . DIRECTORY_SEPARATOR . '*';
		printf("Removing %s<br>", $glob_dir);
		$files = glob( $glob_dir); 
		foreach($files as $file) if(is_file($file)) {
			echo "Deleted: $file" . "<br>";
		    unlink($file); 
		}	
	}

}