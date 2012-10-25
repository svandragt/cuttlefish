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
	foreach (Filesystem::list_files( Filesystem::url_to_path($pages_path), Configuration::CONTENT_EXT) as $key => $value) {
		$filename =  pathinfo($value, PATHINFO_FILENAME  );
		$title = ucwords(str_replace("-"," ",$filename));
		$output .= sprintf("<li><a href='%s'>%s</a></li>",Url::index("/pages/$filename"), $title);
	}
	return $output;
}
