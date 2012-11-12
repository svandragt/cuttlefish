<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

function href($url) {
	$l = new Url();
	return $l->index($url)->url;
}

function pages() {
	Log::debug(__FUNCTION__ . " called.");

	$output = '';
	$pages_path = sprintf("/%s/%s", Configuration::CONTENT_FOLDER, 'pages');
	// todo
 	$files = new Files(array('url' => $pages_path), Configuration::CONTENT_EXT);

	foreach ($files as $key => $value) {
		$filename =  pathinfo($value[0], PATHINFO_FILENAME  );
		$title = ucwords(str_replace("-"," ",$filename));
		$output .= sprintf("<li><a href='%s'>%s</a></li>",href("/pages/$filename"), $title);
	}
	return $output;
}

function theme_dir() {
	$script_url     = substr(strrchr($_SERVER['SCRIPT_NAME'], "/"), 0);
	$path_to_script = str_replace($script_url, '',$_SERVER['URL']);
	$theme_dir_url  = str_replace("\\","/",THEME_DIR);
	return $path_to_script . $theme_dir_url ;
}

function is_loggedin() {
	$sec = new Security();
	return $sec->is_loggedin();
}

function create_commons_li(
		$photo_url, $photo, 
		$author_url, $author,
		$license) {

	$cc = array(
		'CC BY-NC-ND 2.0' => 'http://creativecommons.org/licenses/by-nc-nd/2.0/',
		'CC BY-NC-SA 2.0' => 'http://creativecommons.org/licenses/by-nc-sa/2.0/',
	);

	return sprintf('<li class="credits" xmlns:cc="http://creativecommons.org/ns#" xmlns:dct="http://purl.org/dc/terms/" about="%s"><span property="dct:title">%s</span> (<a rel="cc:attributionURL" property="cc:attributionName" href="%s">%s</a>) / <a rel="license" href="%s">%s</a></li>',
		$photo_url, $photo, 
		$author_url, $author,
		$cc[$license], $license);
}
