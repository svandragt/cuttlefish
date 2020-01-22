<?php

namespace Cuttlefish;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Controller {
	protected $ext;
	protected $args;
	protected $records = [];
	protected $Model;
	protected $View;
	private $content;

	function __construct( $parent, $args ) {
		$this->content = \Configuration::CONTENT_FOLDER;
		$this->ext     = \Configuration::CONTENT_EXT;
		$this->args    = $args;
		$this->init();
	}


	public function init() {
		$this->records();
		$this->model();
		$this->view();
	}

	/**
	 * implement $this->Records in your controller
	 */
	public function records() {
	}

	/**
	 * implement $this->Model in your controller
	 */

	public function model() {
	}

	/**
	 * implement $this->View in your controller
	 */
	public function view() {
		include( 'view_functions.php' );
	}
}
	