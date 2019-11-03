<?php

namespace Mana;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

// @link http://stackoverflow.com/questions/62617/whats-the-best-way-to-separate-php-code-and-html
class Template {

	private $args;
	private $file;

	public function __construct( $file, $args = array() ) {
		$this->file = $file;
		$this->args = $args;
	}

	public function __get( $name ) {
		return $this->args[ $name ];
	}

	public function render() {
		$path = BASE_FILEPATH . THEME_DIR . "views" . DIRECTORY_SEPARATOR . $this->file;
		require $path;
	}
}
