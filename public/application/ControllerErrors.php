<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ControllerErrors extends Controller {

	function __construct($parent, $args) {
		parent::__construct($parent, $args);
		$this->layout     = 'single.php';
		$this->model      = 'Pages';
		$this->controller = 'Errors';

		// $this->content_dir = strtolower(sprintf("/%s/%s",$this->content, $this->model));
	}



	function load_records() {
		parent::load_records();
		$limit = Configuration::POSTS_HOMEPAGE;
    	$this->Records->limit($limit + 5);
	}

	function load_view() {
		parent::load_view();
		// test();
		// feedLink();
		// $view->init();
 
	}

}
