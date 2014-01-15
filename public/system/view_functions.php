<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * Shorthand function to link to internal url
 * @param  string $url internal url
 * @return string      index independent internal url
 */
function href($url) {
	$l = new Url();
	return $l->index($url)->url;
}

/**
 * List pages in templated format
 * @return string html of list of pages
 */
function pages() {
	Log::debug(__FUNCTION__ . " called.");

	$output = '';
	$pages_path = sprintf("/%s/%s", Configuration::CONTENT_FOLDER, 'pages');

 	$files = new Files(array('url' => $pages_path), Configuration::CONTENT_EXT);
	foreach ($files->getCollection() as $path) {
		$filename =  pathinfo($path, PATHINFO_FILENAME  );
		$title = ucwords(str_replace("-"," ",$filename));
		$output .= sprintf("<li><a href='%s'>%s</a></li>",href("/pages/$filename"), $title);
	}
	return $output;
}

/**
 * Returns theme directory
 * @return string link to theme directory
 */
function theme_dir() {
	$script_url     = substr(strrchr($_SERVER['SCRIPT_NAME'], "/"), 0);
	$path_to_script = str_replace($script_url, '',$_SERVER['URL']);
	$theme_dir_url  = str_replace("\\","/",THEME_DIR);
	return $path_to_script . $theme_dir_url ;
}

/**
 * Is the user logged in
 * @return boolean logged in status
 */
function is_loggedin() {
	$sec = new Security();
	return $sec->is_loggedin();
}

/**
 * Shorthand for creating creative commons attribution link
 * @param  string $photo_url  url to photo
 * @param  string $photo      title of photo
 * @param  string $author_url url to author
 * @param  string $author     name of author
 * @param  string $license    name of license
 * @return string             html for cc attr link
 */
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
