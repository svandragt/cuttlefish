<?php

class Model {

	static function load_data($filename) {
		if (is_null($filename)) return null;
		if (!file_exists ($filename )) {
			header('Location: ' . Theming::root() . '/error/404');
		} else {
			$contents =  file_get_contents ( $filename);
			if ($contents) {
				if (class_exists ( 'MarkdownExtra_Parser', false)){
					$c = new MarkdownExtra_Parser;
					$contents =  $c->transform($contents);
				}
				return $contents;
			}
		}
	}
}