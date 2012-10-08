<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Url {

	// all url functions relative, except root
	
	// static function content_file_to_url($file_path) {
	// 	// take a file_path inside the content folder and convert that to a relative url.
	// 	return $file_path;
	// 	// $filepath_base = str_replace('.' . Configuration::CONTENT_EXT, '', $file_path);
	// 	// $root_file_path = str_replace(Filesystem::url_to_path('/' . Configuration::CONTENT_FOLDER),"", $filepath_base);
	// 	// $root_url =  selffile_path_to_url($root_file_path);
	// 	return $root_url;
	// }

	static function theme_dir() {
		Log::debug(__FUNCTION__ . " called.");
		$script_url     = substr(strrchr($_SERVER['SCRIPT_NAME'], "/"), 0);
		$path_to_script = str_replace($script_url, '',$_SERVER['URL']);
		$theme_dir_url  = str_replace("\\","/",THEME_DIR);
		return $path_to_script . $theme_dir_url ;
	}

	static function abs( $url = '') {
		// make a relative url absolute
		return self::protocol() . $_SERVER['HTTP_HOST'] . $url;
	}

	static function protocol() {
		// http://stackoverflow.com/questions/4503135/php-get-site-url-protocol-http-vs-https
    	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    	return $protocol;
	}

	static function pages() {
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


	static function file_path_to_url($file_path) {
		// convert a link to a file (content or otherwise)
		// make sure to call Url::index($url) after

		Log::debug(__FUNCTION__ . " called.");
		$relative_file_path  = Filesystem::file_path_make_relative($file_path);
		Log::debug(__FUNCTION__  . " relative_file_path: $relative_file_path");

		$relative_url  = str_replace(DIRECTORY_SEPARATOR,"/",$relative_file_path);
		$relative_url = '/' . ltrim($relative_url, '/');
		Log::debug(__FUNCTION__  . " relative_url: $relative_url");

		if (! strrpos($relative_url, Configuration::CONTENT_FOLDER) === false) {
			$relative_url = str_replace(Configuration::CONTENT_FOLDER.'/', '',$relative_url);
			$relative_url = str_replace('.' . Configuration::CONTENT_EXT, '',$relative_url);
		}

		return $relative_url;
	}

	static function index($url) {
		// makes sure links work index_page independent		
		$url = Configuration::INDEX_PAGE . $url;
		return $url;
	}

}