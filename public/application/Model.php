<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Model {

	public static $page_model = array(
		'markdown|html' => 'content',
	);

	public static $post_model = array(
		'yaml' => 'metadata',
		'markdown|html' => 'content',
	);

	static function pages($args) {
		Log::debug(__FUNCTION__ . " called.");

		$file_path = $args['file_path'];
		if (Filesystem::is_found($file_path)) {
			$model = new Datamodel($args, self::$page_model);
			$model->model = __FUNCTION__;

			return $model;
		} else {
			header('Location: ' . Url::root(Url::index('/errors/404')));
			exit();
		}
	}

		

	static function posts($args) {
		Log::debug(__FUNCTION__ . " called.");
		
		$file_path = $args['file_path'];
		if (Filesystem::is_found($file_path)) {
			$model = new Datamodel($args, self::$post_model);
			$model->model = __FUNCTION__;

			return $model;
		} else {
			header('Location: ' . Url::root(Url::file_path_to_url('/errors/404')));
			exit();
		}		
	}
}