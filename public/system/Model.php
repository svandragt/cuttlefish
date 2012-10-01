<?php

class Model {

	static function error($file_path) {
		return self::pages($file_path);
	}

	static function pages($file_path) {
		if (Filesystem::is_found($file_path)) {
			$model = new Datamodel($file_path, array(
				'markdown' => 'content',
			));
			return $model;
		} else {
			header('Location: ' . Theming::root() . '/error/404');
			exit();
		}
	}

		

	static function posts($file_path) {
		if (Filesystem::is_found($file_path)) {
			$model = new Datamodel($file_path, array(
				'yaml' => 'metadata',
				'markdown' => 'content',
			));
			return $model;
		} else {
			header('Location: ' . Theming::root() . '/error/404');
			exit();
		}		
	}
}