<?php

use VanDragt\Carbon;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class ControllerPages extends Carbon\Controller {
	// single page

	function records() {
		$this->records = Carbon\Filesystem::url_to_path( '/content/pages/' . implode( $this->args, "/" ) . '.' . $this->ext );
    }

	function model() {
		$this->Model = new ModelPage( $this->records );
	}

	function view() {
		parent::view();

		$this->view = new Carbon\Html( $this->Model->contents, array(
			'layout'     => 'single.php',
			'controller' => 'pages',
			'model'      => 'page',
		) );
	}
}
