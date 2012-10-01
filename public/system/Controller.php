<?php

class Controller {

	static function admin($path_parts) {
		ob_end_clean();
		$action = $path_parts[2];

		switch ($action) {
			case 'cache':
				Cache::clear();
			break;
		}
		printf("<a href='%s'>Return</a><br>",Theming::root());
	}

	static function error($path_parts) {
		header("HTTP/1.0 404 Not Found");
		$function = __FUNCTION__;
		$error_type = $path_parts[2];

		switch ($error_type) {
			case '404':
				$filename = Filesystem::url_to_path("/content/$function/$error_type." . Configuration::CONTENT_EXT);
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


	static function pages($path_parts) {
		$function = __FUNCTION__;
		$item     = $path_parts[2];
		$filename = Filesystem::url_to_path("/content/$function/$item." . Configuration::CONTENT_EXT);
		$data     = call_user_func ("Model::$function",$filename);	

		View::template($data);
	}

	static function posts($path_parts) {
		$function = __FUNCTION__;
		$path_parts  = array_slice($path_parts, 2);
		$item     = implode('/', $path_parts);
		$filename = Filesystem::url_to_path("/content/$function/$item." . Configuration::CONTENT_EXT);
		$data     = call_user_func ("Model::$function",$filename);	

		View::template($data);
	}
}