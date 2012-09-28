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
		// ob_end_clean();
		header("HTTP/1.0 404 Not Found");

		$item = $actions[2];
		$filename = Filesystem::url_to_path('/content/'. __FUNCTION__ ."/$item." . Configuration::MARKDOWN_EXT);
		$content =  (file_exists($filename)) ? Model::load_data($filename) : "Sorry, this page does not exists (404).";
		View::template($content, 'single.php');
	}


	static function index() {
		$content = '';
		foreach (Filesystem::list_files( Filesystem::url_to_path('/content/posts'), 'md') as $key => $value) {
			$content .= Model::load_data($value);
		}
		View::template($content);
	}



	static function pages($actions) {
		$item = $actions[2];
		$filename = Filesystem::url_to_path('/content/'. __FUNCTION__ ."/$item." . Configuration::MARKDOWN_EXT);
		$content = Model::load_data($filename);
		View::template($content);
	}

	static function posts($actions) {
		$item = $actions;
		$item[0] = $item[1] = null;
		$filename = Filesystem::url_to_path('/content/'. __FUNCTION__ ."/$item." . Configuration::MARKDOWN_EXT);
		$content = Model::load_data($filename);
		View::template($content);
	}
}