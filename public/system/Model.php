<?php

class Model {

	public static $page_model = array(
		'markdown|html' => 'content',
	);

	public static $post_model = array(
		'yaml' => 'metadata',
		'markdown|html' => 'content',
	);

	static function error($file_path) {
		return self::pages($file_path);
	}

	static function pages($file_path) {
		if (Filesystem::is_found($file_path)) {
			$model = new Datamodel($file_path, self::$page_model);
			return $model;
		} else {
			header('Location: ' . Theming::root() . '/error/404');
			exit();
		}
	}

		

	static function posts($file_path) {
		if (Filesystem::is_found($file_path)) {
			$model = new Datamodel($file_path, self::$post_model);
			return $model;
		} else {
			header('Location: ' . Theming::root() . '/error/404');
			exit();
		}		
	}
}