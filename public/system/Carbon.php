<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Carbon {

	static function compare_published($a,$b) {
    	return strcmp($b->metadata->Published, $a->metadata->Published);
	}

	static function path_info() {
		Log::debug(__FUNCTION__ . " called.");
		$path_info = $_SERVER['PATH_INFO']; 
		$no_specified_path = is_null($path_info ) || $path_info == '/';
		if ($no_specified_path ) $path_info = Configuration::HOME_PAGE;
		else {
			$ends_with_slash = !substr(strrchr($path_info, "/"), 1);
			if ($ends_with_slash) {
				$slashless_request = substr($path_info, 0, -1);
				header('Location: ' . Url::abs( Url::index( $slashless_request) ));
				exit();
			}
		}
		return $path_info;
	}

	static function router() {
		if (Cache::has_cache()) {
			exit(readfile(Cache::cache_file()));
		} 
		Log::debug(__FUNCTION__ . " called.");
		Setup::environment_start();
		Cache::start();

		// Route to controller
		$path_parts = explode("/", self::path_info());
		$function   = $path_parts[1];
		if ( is_callable ( "Controller::$function")) {
			call_user_func ( "Controller::$function",array_slice($path_parts, 2));
		} else {
			$url = Url::abs( Url::index('/errors/404'));
			Log::info("Not callable 'Controller::$function' or missing parameter.");
			header("Location: $url");
			exit();
		}

		Cache::end();		
		Setup::environment_end();
	}


	static function template_download($template_type) {
		Log::debug(__FUNCTION__ . " called.");
		
    	if (is_null($template_type)) throw new Exception('Template type cannot be null.');
    	
		$ext                = Configuration::CONTENT_EXT;
		$application_folder = Configuration::APPLICATION_FOLDER;
		$filepath_template  = Filesystem::url_to_path("/$application_folder/template-$template_type.$ext");
		$now                = date("Y-m-d H:i:s"); 

		$contents = (file_exists($filepath_template)) ? trim(file_get_contents($filepath_template)) : "Create '$filepath_template' for your $template_type template.";
		$contents = sprintf($contents, $now);
		Http::download_string($contents);
		exit();
	}
}