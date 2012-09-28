<?php

class Controller {

	static function admin($actions) {
		ob_end_clean();
		switch ($actions[2]) {
			case "cache_clear":
				Cache::clear();
			break;
		}
		printf("<a href='%s'>Return</a><br>",Theming::root());
	}

	static function error($actions) {
		header("HTTP/1.0 404 Not Found");

		$item = $actions[2];
		$filename = Filesystem::url_to_path('/content/'. __FUNCTION__ ."/$item." . Configuration::CONTENT_EXT);
		$content =  (file_exists($filename)) ? Model::load_data($filename) : "Sorry, this page does not exists (404). Customise this page by adding a /content/error/404.md.";
		View::template($content, 'single.php');
	}


	static function index() {
		$content = array();
		foreach (Filesystem::list_files( Filesystem::url_to_path('/content/posts'), 'md') as $key => $value) {
			$content[] = Model::load_data($value);
		}
		View::template($content);
	}



	static function pages($actions) {
		$item = $actions[2];
		$filename = Filesystem::url_to_path('/content/'. __FUNCTION__ ."/$item." . Configuration::CONTENT_EXT);
		$content = Model::load_data($filename);
		View::template($content);
	}

	static function posts($actions) {
		$item = array_slice($actions, 2);
		$item = implode('/', $item);
		$filename = Filesystem::url_to_path('/content/'. __FUNCTION__ ."/$item." . Configuration::CONTENT_EXT);
		$content = Model::load_data($filename);
		View::template($content);
	}
}