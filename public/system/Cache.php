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
			$fp = fopen(self::cache_file(), 'w'); 
			$contents = ob_get_contents();
			fwrite($fp, $contents); 
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
		$filename = str_replace("/", "_", substr(Http::server('PATH_INFO'), 1));
		$filename = ($filename) ? $filename : 'index';
		$o = sprintf( "%s/%s.html", Configuration::CACHE_FOLDER, $filename);
		return $o;
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