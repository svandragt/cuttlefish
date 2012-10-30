<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Controller extends Extension {

	function __construct($parent, $args) {
		parent::__construct($parent, $args);

		$this->content     = Configuration::CONTENT_FOLDER;
		$this->ext         = Configuration::CONTENT_EXT;
		$this->args        = $args;
		Log::debug(__FUNCTION__ . " called.");
		$this->init();
	}

	function class_not_callable($named_class) {
		die("class $named_class not callable.");
	}

	public function init() {
 		$this->records();
 		$this->model();
 		$this->view();
	}

	public function records() {
		// implement $this->Records in your controller
	}


	public function model() {
		// implement $this->Model in your controller
	}

	public function view() {
		include ('view_functions.php');
		include ('functions.php');
		// implement $this->View in your controller

	}
}
	