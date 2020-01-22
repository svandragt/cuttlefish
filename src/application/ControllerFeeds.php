<?php



if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class ControllerFeeds extends Cuttlefish\Controller {
	// single feed
	function records() {
		$limit         = Configuration::POSTS_HOMEPAGE;
		$Records       = new Cuttlefish\Files( array( 'url' => '/content/posts' ), $this->ext );
		$this->records = $Records->limit( $limit + 5 );
	}

	function model() {
		$Model       = new ModelPost( $this->records );
		$this->Model = $Model->limit( 10 );
	}

	function view() {
		parent::view();
		$this->View = new Cuttlefish\Feed( $this->Model->contents );
	}
}
