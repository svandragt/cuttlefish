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
		$filename = substr(Http::server('PATH_INFO'), 1);
		$filename = ($filename) ? $filename . '/' : '';
		return sprintf( "%s/%sindex.html", Configuration::CACHE_FOLDER, $filename);
	}

	static function clear() {
		$dir =  BASEPATH . DIRECTORY_SEPARATOR . str_replace("/", DIRECTORY_SEPARATOR, Configuration::CACHE_FOLDER);
		printf("Removing  all files in %s<br>", $dir);
		FileSystem::remove_files($dir,true);
		Filesystem::ensure_folder_exists( Configuration::CACHE_FOLDER );			
	}
}