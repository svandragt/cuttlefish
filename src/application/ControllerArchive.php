<?php


use VanDragt\Carbon;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class ControllerArchive extends Carbon\Controller {

	// list of recent posts

	function records() {
		$files         = new Carbon\Files( array( 'url' => '/content/posts' ), $this->ext );
		$this->records = $files->files();
	}

	function model() {
		$model       = new ModelPost( $this->records );
		$this->Model = $model;
	}

	function view() {
		parent::view();
		$this->view = new Carbon\Html( $this->Model->contents, array(
			'layout'     => 'layout.php',
			'controller' => 'archive',
			'model'      => 'post',
		) );
	}

}