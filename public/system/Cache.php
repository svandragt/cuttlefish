<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Cache extends Extension{

	protected $cwd;

	public function __construct($parent) {
		parent::__construct($parent);
		$this->cwd = getcwd();
	}

	public function end() {
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

		foreach ($fs->collection as $index => $file_path) {
			$file_obj = new File($file_path);
			$url_obj = new Url();
			$cache_urls[] = $url_obj->file_to_url($file_obj)->index();
		}

		$urls = array(
			'/',
			'/feeds/posts',
			'/archive',
		);
		foreach ($urls as $key => $value) {
			$url = new Url();
			$cache_urls[] = $url->index($value);
		}


		foreach ($cache_urls as $url) {
			$url2 = clone $url;
			$contents = $c->url_contents($url2->abs()->url); 

			if (Configuration::CACHE_ENABLED == false) {
				$path = $this->write_cache_to_disk($url, $contents);
				echo "Written: $path<br>". PHP_EOL;		
			}
		}
		$c->close();

		$this->copy_themefiles(array('css', 'js'));

	}

	function write_cache_to_disk($url_obj, $contents) {
		$url = (is_object($url_obj)) ? $url_obj->url : $url_obj;
		$path = $this->cache_file_from_url($url);
		$dirname = pathinfo ($path, PATHINFO_DIRNAME);

		if (!is_dir($dirname)) mkdir ($dirname, 0777, true);
		$fp = fopen($path, 'w'); 
		fwrite($fp, $contents); 
		fclose($fp); 
		return $path;
	}

	function copy_themefiles($file_types) {
		include ('view_functions.php');

		// $files  = array();
		$theme_dir = rtrim(theme_dir(), '/');
		echo "Copying files from theme: <br><br>";


		foreach ($file_types as $file_type) {
			echo "filetype: $file_type<br>";
			$fs = new Files( array('path' => Filesystem::url_to_path("$theme_dir")), $file_type);

			$destination_files = array();
			foreach ($fs->collection as $key => $value) {
				echo "$key: $value<br>";
				$cache = ltrim(Configuration::CACHE_FOLDER,"./");	
				$destination_files[] = str_replace('public', $cache, $value);
			}
			Filesystem::copy_files($fs->collection, $destination_files);
		}
	}


}

