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
