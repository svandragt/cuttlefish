<?php

class Carbon {

	static function router() {
		if (Cache::has_cache()) {
			include(Cache::cache_file()); 
			exit();
		} 
		Setup::environment_start();
		Cache::start();

		$actions = explode("/", Carbon::page_path());
		$function = $actions[1];
		if ( is_callable ( "Controller::$function")) {
			call_user_func ( "Controller::$function",$actions);
		} else {
			Log::info("not callable '$function' or missing parameter.");
			header('Location: ' . Theming::root() . '/error/404');
			exit();
		}

		Cache::end();		
		Setup::environment_end();
	}


	static function page_path() {
		$path_info = Http::server('PATH_INFO'); 
		if (is_null($path_info ) || $path_info == '/' ) {
			$path_info = Configuration::HOME_PAGE;
		} else {
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