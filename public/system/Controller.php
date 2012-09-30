<?php

class Controller {

	static function admin($actions) {
		ob_end_clean();
		switch ($actions[2]) {
			case 'cache':
				Cache::clear();
			break;
		}
		printf("<a href='%s'>Return</a><br>",Theming::root());
	}

	static function error($actions) {
		header("HTTP/1.0 404 Not Found");
		$function = __FUNCTION__;
		$item = $actions[2];

		switch ($item) {
			case '404':
				$filename = Filesystem::url_to_path("/content/$function/$item." . Configuration::CONTENT_EXT);
				$data =  (file_exists($filename)) ? call_user_func ("Model::$function",$filename) : "Sorry, this page does not exists (404). Customise this page by adding a /content/error/404.md.";
				View::template($data, 'single.php');
			break;
		}
 	}


	static function index() {
		$data = array();
		foreach (Filesystem::list_files( Filesystem::url_to_path('/content/posts'), 'md') as $key => $value) {
			$data[] = call_user_func ("Model::posts",$value);	
		}
		View::template($data);
	}


	static function pages($actions) {
		$function = __FUNCTION__;
		$item = $actions[2];
		$filename = Filesystem::url_to_path("/content/$function/$item." . Configuration::CONTENT_EXT);
		$data = call_user_func ("Model::$function",$filename);	

		View::template($data);
	}

	static function posts($actions) {
		$function = __FUNCTION__;
		$actions = array_slice($actions, 2);
		$item = implode('/', $actions);
		$filename = Filesystem::url_to_path("/content/$function/$item." . Configuration::CONTENT_EXT);
		$data = call_user_func ("Model::$function",$filename);	
		View::template($data);
	}
}