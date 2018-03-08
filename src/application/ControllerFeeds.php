<?php

use VanDragt\Carbon;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class ControllerFeeds extends Carbon\Controller {
	// single feed
	function records() {
		$limit         = \Configuration::POSTS_HOMEPAGE;
		$records       = new Carbon\Files( array( 'url' => '/content/posts' ), $this->ext );
		$this->records = $records->limit( $limit + 5 );
	}

	function model() {
		$model       = new ModelPost( $this->records );
		$this->Model = $model->limit( 10 );
	}

	function view() {
		parent::view();
		$this->view = new Carbon\Feed( $this->Model->contents );
	}
}
