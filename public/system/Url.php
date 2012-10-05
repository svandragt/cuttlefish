<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Url {
	
	static function content_url($file_path) {
		// only suitable for calls to inside the content folder
		$filepath_base = str_replace('.' . Configuration::CONTENT_EXT, '', $file_path);
		$root_file_path = Configuration::INDEX_PAGE . str_replace(Filesystem::url_to_path('/' . Configuration::CONTENT_FOLDER),"", $filepath_base);
		$root_url =  str_replace( DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR,"/",$root_file_path);
		return $root_url;
	}
	static function theme_dir() {
		$script_url     = substr(strrchr(Http::server('SCRIPT_NAME'), "/"), 0);
		$path_to_script = str_replace($script_url, '',Http::server('URL'));
		$theme_dir_url  = str_replace("\\","/",THEME_DIR);
		return $path_to_script . $theme_dir_url ;
	}

	static function root( $url = '') {
		return "http://" . Http::server('HTTP_HOST') . $url;
	}

	static function pages() {
		$output = '';
		$pages_path = sprintf("/%s/%s", Configuration::CONTENT_FOLDER, 'pages');
		foreach (Filesystem::list_files( Filesystem::url_to_path($pages_path), Configuration::CONTENT_EXT) as $key => $value) {
			$filename =  pathinfo($value, PATHINFO_FILENAME  );
			$title = ucwords(str_replace("-"," ",$filename));
			$output .= sprintf("<li><a href='%s'>%s</a></li>",Url::content_url("/pages/$filename"), $title);
		}
		return $output;
	}

	static function path_to_url($file_path) {
		$root_path = Filesystem::url_to_path('/');
		$root_url  = str_replace($root_path,"",$file_path);
		$root_url  = '/' . str_replace("\\","/",$root_url);
		$url = str_replace(Configuration::CONTENT_FOLDER.'/', '',$root_url);
		return self::root( $url );
	}

}