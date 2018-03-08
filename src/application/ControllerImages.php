<?php

use VanDragt\Carbon;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class ControllerImages extends Carbon\Controller {
	// single image

	function records() {
		$this->records = Carbon\Filesystem::url_to_path( '/content/images/' . implode( $this->args, "/") );
	}

	function model() {
		$this->Model = new ModelFile( $this->records );
	}

	function view() {
		parent::view();

		$this->view = new Carbon\File( $this->Model->contents );
		$this->view->render();
	}
}
