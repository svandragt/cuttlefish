<?php

class Theming {
	
	static function theme_dir() {
		$script_url     = substr(strrchr(Http::server('SCRIPT_NAME'), "/"), 0);
		$path_to_script = str_replace($script_url, '',Http::server('URL'));
		$theme_dir_url  = str_replace("\\","/",THEME_DIR);
		return "http://" . Http::server('HTTP_HOST') . $path_to_script . $theme_dir_url ;
	}

	static function root() {
		return "http://" . Http::server('HTTP_HOST') . Http::server('SCRIPT_NAME');
	}

	static function pages() {
		$output = '';
		foreach (Filesystem::list_files( Filesystem::url_to_path('/content/pages'), Configuration::CONTENT_EXT) as $key => $value) {
			$filename =  pathinfo($value, PATHINFO_FILENAME  );
			$output .= sprintf("<li><a href='%s/pages/%s'>%s</a></li>",Theming::root(), $filename, ucwords($filename));
		}
		return $output;

	}

}