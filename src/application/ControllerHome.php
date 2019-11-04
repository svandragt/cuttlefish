<?php



if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class ControllerHome extends Mana\Controller {
	// list of recent posts

	function records() {
		$limit         = Configuration::POSTS_HOMEPAGE;
		$Files         = new Mana\Files( array( 'url' => '/content/posts' ), $this->ext );
		$this->records = $Files->limit( $limit + 5 );
	}

	function model() {
		$Model       = new ModelPost( $this->records );
		$this->Model = $Model->limit( Configuration::POSTS_HOMEPAGE );
	}

	function view() {
		parent::view();

		$this->View = new Mana\Html( $this->Model->contents, array(
			'layout'     => 'layout.php',
			'controller' => 'home',
			'model'      => 'post',
		) );

	}
}