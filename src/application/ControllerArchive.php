<?php


use VanDragt\Carbon;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class ControllerArchive extends Carbon\Controller {

	// list of recent posts

	function records() {
		$Files         = new Carbon\Files( array( 'url' => '/content/posts' ), $this->ext );
		$this->records = $Files->files();
	}

	function model() {
		$Model       = new ModelPost( $this->records );
		$this->Model = $Model;
	}

	function view() {
		parent::view();
		$this->View = new Carbon\Html( $this->Model->contents, array(
			'layout'     => 'layout.php',
			'controller' => 'archive',
			'model'      => 'post',
		) );
	}

}