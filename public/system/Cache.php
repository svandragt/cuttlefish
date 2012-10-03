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
		$ext = (strrpos($filename, 'feed') === false) ? 'html' : 'xml';
		return sprintf( "%s/%sindex.%s", Configuration::CACHE_FOLDER, $filename, $ext);
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

		self::copy_themefiles(array('css', 'js'));
	}

	static function copy_themefiles($file_types) {
		$files  = array();
		$theme_dir = Theming::theme_dir();
		$theme_dir = str_replace(Theming::root(), '', $theme_dir);
		$theme_dir = rtrim($theme_dir, '/');

		echo "Copying files from theme: <br><br>";


		foreach ($file_types as $file_type) {
			$source_files = Filesystem::list_files( Filesystem::url_to_path("$theme_dir"), $file_type);
			$destination_files = array();
			foreach ($source_files as $key => $value) {
				echo "$key: $value<br>";
				$cache = ltrim(Configuration::CACHE_FOLDER,"./");	
				$destination_files[] = str_replace('public', $cache, $value);
			}
			Filesystem::copy_files($source_files, $destination_files);
		}
	}
}