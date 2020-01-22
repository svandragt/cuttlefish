<?php




if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class ModelFile extends Cuttlefish\Model {

	// File model

	public $model = array();

	function contents( $records ) {
		$this->contents = $records;
	}

}