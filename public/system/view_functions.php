<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

function href($url) {
	$l = new Url();
	return $l->index($url)->url;
}

function pages() {
	// todo
	Log::debug(__FUNCTION__ . " called.");

	$output = '';
	$pages_path = sprintf("/%s/%s", Configuration::CONTENT_FOLDER, 'pages');
	// todo
 	$files = new Files($pages_path, Configuration::CONTENT_EXT);

	foreach ($files as $key => $value) {
		$filename =  pathinfo($value[0], PATHINFO_FILENAME  );
		$title = ucwords(str_replace("-"," ",$filename));
		$output .= sprintf("<li><a href='%s'>%s</a></li>",href("/pages/$filename"), $title);
	}
	return $output;
}

function theme_dir() {
		// todo
		$script_url     = substr(strrchr($_SERVER['SCRIPT_NAME'], "/"), 0);
		$path_to_script = str_replace($script_url, '',$_SERVER['URL']);
		$theme_dir_url  = str_replace("\\","/",THEME_DIR);
		return $path_to_script . $theme_dir_url ;
}
