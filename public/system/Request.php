<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Request {

	function __construct() {
		$this->Cache      = new Cache();
		if ($this->Cache->has_existing_cachefile()) {
			exit(readfile($this->Cache->cache_file_from_url()));
		} 
		Log::debug(__FUNCTION__ . " called.");

		$this->Environment      = new Environment();
		$this->Cache->start();

		// Route to controller
		$path_parts           = explode("/", $this->path_info());
		$controller_class     = 'Controller' . ucfirst($path_parts[1]);
		$controller_arguments = array_slice($path_parts, 2);
		if ( class_exists ( $controller_class, true )) {
			$this->controller = new $controller_class( $this, $controller_arguments );
			$this->controller->init();
		} else $this->class_not_callable($controller_class);
	}

	function class_not_callable($controller_class) {
		$url = new Url();
		$args = array(
			'url' => $url->index('/errors/404')->abs(),
			'logmessage' => "Not callable '$controller_class' or missing parameter.",
		);
		$this->redirect($args);
	}


	function redirect($args) {
		$url = new Url();
		$defaults = array (
			'logmessage' => 'Redirection...',
			'url' => $url->index('/errors/404')->abs(),
		);
		$args = array_merge($defaults, $args);
		print_r($args);
		Log::info($args['logmessage']);
		echo("Location: " . $args['url']->url);
		exit($args['logmessage']);
	}




	function path_info() {
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


	function template_download($template_type) {
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