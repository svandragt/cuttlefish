<?php



if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class ControllerImages extends Mana\Controller {
	// single image

	function records() {
		$this->records = [ Mana\Filesystem::url_to_path( '/content/images/' . implode( $this->args, "/" ) ) ];
	}

	function model() {
		$this->Model = new ModelFile( $this->records );
	}

	function view() {
		parent::view();

		$this->View = new Mana\File( $this->Model->contents );
		$this->View->render();
	}
}
