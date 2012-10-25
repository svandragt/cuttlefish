<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Url {

	public $url;
	public $is_relative; // made absolute?
	public $is_prefixed; // been through index function

	// all url functions relative, except root
	

	function __construct() { }

	static function theme_dir() {
		// todo
		Log::debug(__FUNCTION__ . " called.");
		$script_url     = substr(strrchr($_SERVER['SCRIPT_NAME'], "/"), 0);
		$path_to_script = str_replace($script_url, '',$_SERVER['URL']);
		$theme_dir_url  = str_replace("\\","/",THEME_DIR);
		return $path_to_script . $theme_dir_url ;
	}

	function abs() {
		// make a relative url absolute
		if ($this->is_relative) {
			$this->url = $this->protocol() . $_SERVER['HTTP_HOST'] . $this->url;
			$this->is_relative = false;
		}
		return $this;
	}

	function protocol() {
		// http://stackoverflow.com/questions/4503135/php-get-site-url-protocol-http-vs-https
    	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    	return $protocol;
	}

	function pages() {
		// todo
		Log::debug(__FUNCTION__ . " called.");

		$output = '';
		$pages_path = sprintf("/%s/%s", Configuration::CONTENT_FOLDER, 'pages');
		foreach (Filesystem::list_files( Filesystem::url_to_path($pages_path), Configuration::CONTENT_EXT) as $key => $value) {
			$filename =  pathinfo($value, PATHINFO_FILENAME  );
			$title = ucwords(str_replace("-"," ",$filename));
			$output .= sprintf("<li><a href='%s'>%s</a></li>",Url::index("/pages/$filename"), $title);
		}
		return $output;
	}


	function file_path_to_url($file) {
		// convert a link to a file (content or otherwise)
		// make sure to call Url::index($url) after
		$file = $file->relative();


		$relative_url  = str_replace(DIRECTORY_SEPARATOR,"/",$file->path);
		$relative_url = '/' . ltrim($relative_url, '/');
		Log::debug(__FUNCTION__  . " relative_url: $relative_url");

		if (! strrpos($relative_url, Configuration::CONTENT_FOLDER) === false) {
			$relative_url = str_replace(Configuration::CONTENT_FOLDER.'/', '',$relative_url);
			$relative_url = str_replace('.' . Configuration::CONTENT_EXT, '',$relative_url);
		}

		$this->url = $relative_url;
		$this->is_relative = true;
		$this->is_prefixed = false;


		return $this;
	}

	function index($url = null) {
		// makes sure links work index_page independent	
		if (!$this->is_prefixed) {
			$this->url = (is_null($url)) ? $this->url : $url;
			$this->url = Configuration::INDEX_PAGE . $this->url;
			$this->is_prefixed = true;
		}
		return $this;
	}

}