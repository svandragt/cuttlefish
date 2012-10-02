<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Theming {
	
	static function content_url($file_path) {
		$filepath_base = str_replace('.' . Configuration::CONTENT_EXT, '', $file_path);
		$root_file_path = str_replace(Filesystem::url_to_path('/' . Configuration::CONTENT_FOLDER),"", $filepath_base);
		$root_url = self::root() . str_replace("\\","/",$root_file_path);
		return $root_url;
	}
	static function theme_dir() {
		$script_url     = substr(strrchr(Http::server('SCRIPT_NAME'), "/"), 0);
		$path_to_script = str_replace($script_url, '',Http::server('URL'));
		$theme_dir_url  = str_replace("\\","/",THEME_DIR);
		return "http://" . Http::server('HTTP_HOST') . $path_to_script . $theme_dir_url ;
	}

	static function root() {
		return "http://" . Http::server('HTTP_HOST') .  Carbon::index_page();
	}

	static function pages() {
		$output = '';
		$pages_path = sprintf("/%s/%s", Configuration::CONTENT_FOLDER, 'pages');
		foreach (Filesystem::list_files( Filesystem::url_to_path($pages_path), Configuration::CONTENT_EXT) as $key => $value) {
			$filename =  pathinfo($value, PATHINFO_FILENAME  );
			$title = ucwords(str_replace("-"," ",$filename));
			$output .= sprintf("<li><a href='%s/pages/%s'>%s</a></li>",Theming::root(), $filename, $title);
		}
		return $output;
	}

}