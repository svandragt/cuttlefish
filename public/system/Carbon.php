<?php

class Carbon {

	static function router() {
		if (Cache::has_cache()) {
			include(Cache::cache_file()); 
			exit();
		} 
		Setup::environment_start();
		Cache::start();

		$path_paths = explode("/", self::path_info());
		$function = $path_paths[1];
		if ( is_callable ( "Controller::$function")) {
			call_user_func ( "Controller::$function",$path_paths);
		} else {
			Log::info("Not callable 'Controller::$function' or missing parameter.");
			header('Location: ' . Theming::root() . '/error/404');
			exit();
		}

		Cache::end();		
		Setup::environment_end();
	}


	static function path_info() {
		$path_info = Http::server('PATH_INFO'); 
		$no_specified_path = is_null($path_info ) || $path_info == '/';
		if ($no_specified_path ) $path_info = Configuration::HOME_PAGE;
		else {
			$ends_with_slash = !substr(strrchr($path_info, "/"), 1);
			if ($ends_with_slash) {
				header('Location: ' . Theming::root() . substr($path_info, 0, -1));
				exit();
			}
		}
		return $path_info;
	}

	static function index_page() {
		$index = str_replace('/index.php', Configuration::INDEX_PAGE, Http::server('SCRIPT_NAME'));
		$index = str_replace('//', '/', $index);
		return $index;
	}
}