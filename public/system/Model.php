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
			$model = new stdClass();
			$model->filename = $filename;
			$model->link     = Theming::content_url($filename);

			$segments = preg_split( '/\R\R/',  trim(file_get_contents($model->filename)), self::TOTAL_SECTIONS);

			$content_segments = preg_split( '/=\R/',  trim($segments[self::CONTENT]), 2);	
			$title_segments = preg_split( '/\R/',  trim($segments[self::CONTENT]), 2);	
			$model->title = $title_segments[0];

			if (isset($segments[self::METADATA])) if (Ext::class_loaded( 'Spyc')){
				$c = new Spyc;
				$model->meta_data =  $c->YAMLLoadString($segments[self::METADATA]);
			}
			if (isset($segments[self::CONTENT])) {
				if (Ext::class_loaded( 'MarkdownExtra_Parser')){
					$c = new MarkdownExtra_Parser;
					$model->content =  $c->transform($content_segments[1]);
				}
				else {
					// fallback
					$model->content =  $content_segments[1];
				}
			}

			return $model;
		}
	}
}