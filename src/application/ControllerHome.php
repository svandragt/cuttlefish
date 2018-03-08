<?php

use VanDragt\Carbon;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class ControllerHome extends Carbon\Controller {
	// list of recent posts

	function records() {
		$limit         = \Configuration::POSTS_HOMEPAGE;
		$files         = new Carbon\Files( array( 'url' => '/content/posts' ), $this->ext );
		$this->records = $files->limit( $limit + 5 );
	}

	function model() {
		$model       = new ModelPost( $this->records );
		$this->Model = $model->limit( \Configuration::POSTS_HOMEPAGE );
	}

	function view() {
		parent::view();

		$this->view = new Carbon\Html( $this->Model->contents, array(
			'layout'     => 'layout.php',
			'controller' => 'home',
			'model'      => 'post',
		) );

	}
}