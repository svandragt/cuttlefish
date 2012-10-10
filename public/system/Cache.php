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
			$path = self::write_cache_to_disk( null, ob_get_contents() );
			ob_end_flush();
		}
	}

	static function has_cacheable_page_request() {
		$has_path     = !is_null(Carbon::path_info());
		$is_caching   = !ob_get_level() == 0;
		$has_noerrors = is_null(error_get_last());
		$has_cacheable_page_request = ($has_path && $is_caching && $has_noerrors);
		return $has_cacheable_page_request;
	}


	static function has_existing_cachefile() {
		$cache_file          = self::cache_file_from_url();
		$has_cache_file      = file_exists($cache_file);
		$has_caching_enabled = Configuration::CACHE_ENABLED;

		return ( $has_cache_file && $has_caching_enabled );
	}


	static function cache_file_from_url($path_info = null) {
		$ds = DIRECTORY_SEPARATOR;
		if ( is_null( $path_info) ) {
			$path_info = substr($_SERVER['PATH_INFO'], 1);
		}
		$path_info = ltrim($path_info, '/');
		$filename =  pathinfo ( $path_info , PATHINFO_DIRNAME  ) .'/'. pathinfo ( $path_info , PATHINFO_FILENAME );
		$filename = ltrim($filename, '.');

		$ext = pathinfo ( $path_info , PATHINFO_EXTENSION);
		if (strrpos($path_info, '.') === false) {
			$filename = rtrim($filename,'/'). '/index';
			$ext = 'html';

			if (!strrpos($filename, 'feed') === false) $ext = 'xml';
		} 
		$cache_file = sprintf( "%s/%s.%s", Configuration::CACHE_FOLDER, ltrim($filename, '/'), $ext);
		$cache_file = str_replace('/', $ds, $cache_file);

		return $cache_file;
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
		if (Configuration::INDEX_PAGE !== '' ) {
			die('Currently, generating a static site requires enabling Pretty Urls (see readme.md for instructions).');
		}
		Cache::clear();

		echo "<br>Generating site:<br>". PHP_EOL;
		$content = Configuration::CONTENT_FOLDER;
		$ext     = Configuration::CONTENT_EXT;
		$c       = new Curl;
		$files   = array();
		$files[] = Filesystem::url_to_path("/". Configuration::CONTENT_FOLDER . "/"); // hack to get index.php
		$files[] = Filesystem::url_to_path("/". Configuration::CONTENT_FOLDER . "/") . "feed";
		$files[] = Filesystem::url_to_path("/". Configuration::CONTENT_FOLDER . "/") . "archive";
		foreach (Filesystem::list_files( Filesystem::url_to_path("/$content"), $ext ) as $key => $value) {
			$files[] = $value;
		}
		foreach ($files as $index => $file_path) {
			echo "$index: $file_path<br>";
			$path_info = Url::file_path_to_url($file_path);
			$url = Url::abs(Url::index( $path_info ));
			echo "url: $url<br>";
			$c->url_contents($url); 

			if (Configuration::CACHE_ENABLED == false) {
				$path = self::write_cache_to_disk($path_info, $contents);
				echo "written: $path<br>". PHP_EOL;		
			}
		}
		$c->close();

		Setup::webserver();
		self::copy_themefiles(array('css', 'js'));
		self::copy_images();

	}

	static function write_cache_to_disk($path_info, $contents) {
		$path = self::cache_file_from_url($path_info);

		$dirname = pathinfo ($path, PATHINFO_DIRNAME);

		if (!is_dir($dirname)) mkdir ($dirname, 0777, true);
		$fp = fopen($path, 'w'); 
		fwrite($fp, $contents); 
		fclose($fp); 
		return $path;
	}

	static function copy_themefiles($file_types) {
		$files  = array();
		$theme_dir = rtrim(Url::theme_dir(), '/');
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


	static function copy_images() {
		$files  = array();
		$content = Configuration::CONTENT_FOLDER;
		$path = Filesystem::url_to_path("/$content/images");
		echo "<br>Copying images: <br><br>";

		$source_files = Filesystem::list_files( $path);
		$destination_files = array();
		foreach ($source_files as $key => $value) {
			echo "$key: $value<br>";
			$cache = ltrim(Configuration::CACHE_FOLDER,"./");	
			$destination_files[] = str_replace('public' . DIRECTORY_SEPARATOR . 'content', $cache, $value);
		}
		Filesystem::copy_files($source_files, $destination_files);
	}

}

