<?php



if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class ControllerPages extends Mana\Controller {
	// single page

	function records() {
		$this->records = [ Mana\Filesystem::url_to_path( '/content/pages/' . implode( $this->args, "/" ) . '.' . $this->ext ) ];
	}

	function model() {
		$this->Model = new ModelPage( $this->records );
	}

	function view() {
		parent::view();

		$this->View = new Mana\Html( $this->Model->contents, array(
			'layout'     => 'layout.php',
			'controller' => 'pages',
			'model'      => 'page',
		) );
	}
}
