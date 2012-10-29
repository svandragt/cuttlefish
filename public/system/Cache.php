<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Cache extends Extension{

	protected $cwd;

	public function __construct($parent) {
		parent::__construct($parent);
		$this->cwd = getcwd();
	}

	public function __destruct() {
		chdir($this->cwd); // Not a bug (LOL): https://bugs.php.net/bug.php?id=30210
		if ( $this->has_cacheable_page_request() ) {
			$path = $this->write_cache_to_disk( null, ob_get_contents() );
			ob_end_flush();
		}
	}

	function abort() {
		while (ob_get_level() > 0) {
			ob_end_clean();
		}
	}


	function start() {
		ob_start();
	}

	function has_cacheable_page_request() {
		$is_caching   = !ob_get_level() == 0;
		$has_noerrors = is_null(error_get_last());
		$has_cacheable_page_request = ($is_caching && $has_noerrors);
		return $has_cacheable_page_request;
	}


	function has_existing_cachefile() {
		$cache_file          = $this->cache_file_from_url();
		$has_cache_file      = file_exists($cache_file);
		$has_caching_enabled = Configuration::CACHE_ENABLED;

		return ( $has_cache_file && $has_caching_enabled );
	}


	function cache_file_from_url($path_info = null) {
		$ds = DIRECTORY_SEPARATOR;
		if ( is_null( $path_info) ) {
			$path_info = substr($_SERVER['PATH_INFO'], 1);
		}
		$path_info = ltrim($path_info, '/');
		$filename  = pathinfo ( $path_info , PATHINFO_DIRNAME  ) .'/'. pathinfo ( $path_info , PATHINFO_FILENAME );
		$filename  = ltrim($filename, '.');

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

	function clear() {
		$dir =  BASEPATH . DIRECTORY_SEPARATOR . str_replace("/", DIRECTORY_SEPARATOR, Configuration::CACHE_FOLDER);
		$dir = realpath($dir);
		printf("Removing  all files in %s<br>", $dir);
		$files = new Files(array('path' => $dir));
		$files->remove_files();
		$dirs = Filesystem::subdirs(realpath($dir.'/.'), false);
		foreach ($dirs as $dir) {
			Filesystem::remove_dirs(realpath($dir.'/.'));
		}
		$this->_parent->Environment->webserver_configuration();
	}

	function generate_site() {
		// todo

		if (Configuration::INDEX_PAGE !== '' ) {
			die('Currently, generating a site requires enabling Pretty Urls (see readme.md for instructions).');
		}
		$this->clear();

		echo "<br>Generating site:<br>". PHP_EOL;
		$content = Configuration::CONTENT_FOLDER;
		$ext     = Configuration::CONTENT_EXT;
		$c       = new Curl;
		$fs = new Files( array('path' => Filesystem::url_to_path("/$content"), $ext));
		$fs->collection[] = Filesystem::url_to_path("/". Configuration::CONTENT_FOLDER . "/"); // hack to get index.php
		// todo: feeds and archive
		// $fs->collection[] = Filesystem::url_to_path("/") . "feeds";
		// $fs->collection[] = Filesystem::url_to_path("/". Configuration::CONTENT_FOLDER . "/") . "archive";

		foreach ($fs->collection as $index => $file_path) {
			$file_obj = new File($file_path);
			$url_obj = new Url();
			$url = $url_obj->file_to_url($file_obj)->index()->url;
			// echo "url: $url<br>" . PHP_EOL;
			$contents = $c->url_contents($url); 

			if (Configuration::CACHE_ENABLED == false) {
				$path = $this->write_cache_to_disk($url, $contents);
				echo "Written: $path<br>". PHP_EOL;		
			}
		}
		// $c->close();

		// Setup::webserver();
		// $this->copy_themefiles(array('css', 'js'));
		// $this->copy_images();

	}

	function write_cache_to_disk($path_info, $contents) {
		$path = $this->cache_file_from_url($path_info);
		$dirname = pathinfo ($path, PATHINFO_DIRNAME);

		if (!is_dir($dirname)) mkdir ($dirname, 0777, true);
		$fp = fopen($path, 'w'); 
		fwrite($fp, $contents); 
		fclose($fp); 
		return $path;
	}

	function copy_themefiles($file_types) {
		// todo 
		// $files  = array();
		// $theme_dir = rtrim(Url::theme_dir(), '/');
		// echo "Copying files from theme: <br><br>";


		// foreach ($file_types as $file_type) {
		// 	$source_files = Filesystem::collect( Filesystem::url_to_path("$theme_dir"), $file_type);
		// 	$destination_files = array();
		// 	foreach ($source_files as $key => $value) {
		// 		echo "$key: $value<br>";
		// 		$cache = ltrim(Configuration::CACHE_FOLDER,"./");	
		// 		$destination_files[] = str_replace('public', $cache, $value);
		// 	}
		// 	Filesystem::copy_files($source_files, $destination_files);
		// }
	}


	function copy_images() {
		// todo
		
		// $files  = array();
		// $content = Configuration::CONTENT_FOLDER;
		// $path = Filesystem::url_to_path("/$content/images");
		// echo "<br>Copying images: <br><br>";

		// $source_files = Filesystem::collect( $path);
		// $destination_files = array();
		// foreach ($source_files as $key => $value) {
		// 	echo "$key: $value<br>";
		// 	$cache = ltrim(Configuration::CACHE_FOLDER,"./");	
		// 	$destination_files[] = str_replace('public' . DIRECTORY_SEPARATOR . 'content', $cache, $value);
		// }
		// Filesystem::copy_files($source_files, $destination_files);
	}

}

