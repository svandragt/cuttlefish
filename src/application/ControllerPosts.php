<?php

use VanDragt\Carbon;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class ControllerPosts extends Carbon\Controller {
	// single post

	function records() {
		$this->records = Carbon\Filesystem::url_to_path( '/content/posts/' . implode( $this->args, "/" ) . '.' . $this->ext );
	}

	function model() {
		$this->Model = new ModelPost( $this->records );
	}

	function view() {
		parent::view();

		$this->view = new Carbon\Html( $this->Model->contents, array(
			'layout'     => 'single.php',
			'controller' => 'posts',
			'model'      => 'post',
		) );
	}
}