<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Model extends Extension {

	public static $model = array(
	);

	function __construct($parent) {
		parent::__construct($parent);

		// $file_path = $args['file_path'];
		// if (Filesystem::is_found($file_path)) {
		// 	$model = new Datamodel($args, self::$post_model);
		// 	$model->model = __FUNCTION__;

		// 	return $model;
		// } else {
		// 	header('Location: ' . Url::abs(Url::index('/errors/404')));
		// 	exit();
		// }				

	}

	public function init() {
		parent::init();
	}


	// static function pages($args) {
	// 	Log::debug(__FUNCTION__ . " called.");

	// 	$file_path = $args['file_path'];
	// 	if (Filesystem::is_found($file_path)) {
	// 		$model = new Datamodel($args, self::$page_model);
	// 		$model->model = __FUNCTION__;

	// 		return $model;
	// 	} else {
	// 		header('Location: ' . Url::abs(Url::index('/errors/404')));
	// 		exit();
	// 	}
	// }

		

	// static function posts($args) {
	// 	Log::debug(__FUNCTION__ . " called.");
		
	// 	$file_path = $args['file_path'];
	// 	if (Filesystem::is_found($file_path)) {
	// 		$model = new Datamodel($args, self::$post_model);
	// 		$model->model = __FUNCTION__;

	// 		return $model;
	// 	} else {
	// 		header('Location: ' . Url::abs(Url::index('/errors/404')));
	// 		exit();
	// 	}		
	// }
}