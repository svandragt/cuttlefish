<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Url {

	public $url;
	public $is_relative; // made absolute?
	public $is_prefixed; // been through index function

	// all url functions relative, except root
	

	function __construct() { }

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

	function file_to_url($file_object) {
		// convert a link to a file (content or otherwise)
		// make sure to call Url::index($url) after
		$file_object = $file_object->relative();


		$relative_url  = str_replace(DIRECTORY_SEPARATOR,"/",$file_object->path);
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