<?php


use VanDragt\Carbon;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class ControllerErrors extends Carbon\Controller {
	// single errors page

	function records() {
		$this->records = [ Carbon\Filesystem::url_to_path( '/content/errors/' . implode( $this->args, "/" ) . '.' . $this->ext ) ];
	}

	function model() {
		$this->Model = new ModelPage( $this->records );
	}

	function view() {
		parent::view();

		$this->View = new Carbon\Html( $this->Model->contents, array(
			'layout'     => 'layout.php',
			'controller' => 'errors',
			'model'      => 'page',
		) );
	}
}
