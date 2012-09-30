<?php

class Model {
	const METADATA = 0;
	const CONTENT = 1;
	const TOTAL_SECTIONS = 2;

	static function error($filename) {
		return self::pages($filename);
	}

	static function pages($filename) {
		if (is_null($filename)) return null;
		if (!file_exists ($filename )) {
			Log::info("'$filename' cannot be found.");
			header('Location: ' . Theming::root() . '/error/404');
		} else {
			$content = trim(file_get_contents($filename));
			
			$model = new stdClass();
			if (Ext::class_loaded( 'MarkdownExtra_Parser')){
				$c = new MarkdownExtra_Parser;
				$model->content =  $c->transform($content);
			}
			else {
				$model->content =  $content;
			}
			return $model;
		}
	}

		

	static function posts($filename) {
		if (is_null($filename)) return null;
		if (!file_exists ($filename )) {
			Log::info("'$filename' cannot be found.");
			header('Location: ' . Theming::root() . '/error/404');
		} else {

			$segments = preg_split( '/\R\R/',  trim(file_get_contents($filename)), self::TOTAL_SECTIONS);

			$model = new stdClass();
			if (isset($segments[self::METADATA])) if (Ext::class_loaded( 'Yaml')){
				$c = new Yaml;
				$model->meta_data =  $c->parse_string($segments[self::METADATA]);
			}
			if (isset($segments[self::CONTENT])) {
				if (Ext::class_loaded( 'MarkdownExtra_Parser')){
					$c = new MarkdownExtra_Parser;
					$model->content =  $c->transform($segments[self::CONTENT]);
				}
				else {
					$model->content =  $segments[self::CONTENT];
				}
			}

			return $model;
		}
	}
}