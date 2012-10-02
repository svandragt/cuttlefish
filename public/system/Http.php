<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Http {

	static function get($key) {

		return (isset($_GET[$key])) ? htmlspecialchars($_GET[$key]) : null;
	}

	static function post($key) {

		return (isset($_POST[$key])) ? htmlspecialchars($_POST[$key]) : null;
	}

	static function server($key) {

		return (isset($_SERVER[$key])) ? htmlspecialchars($_SERVER[$key]) : null;
	}

	static function session($key) {

		return (isset($_SESSION[$key])) ? htmlspecialchars($_SESSION[$key]) : null;
	}


	static function download_string($contents) {
	    $filename = sprintf("cbn_%s.%s",  date("Y-m-d_H-i-s",time()), Configuration::CONTENT_EXT);
	    header ("Content-Type: text/plain");
	    header ("Content-disposition: attachment; filename=$filename");
	    print $contents;
	    exit();
	}

	static function set_session($values) {
		foreach ($values as $key => $value) {
			$_SESSION[$key] = $value;
		}
	}

}