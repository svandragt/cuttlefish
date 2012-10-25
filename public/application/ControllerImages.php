<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ControllerImages extends Controller {

	function __construct($parent, $args) {
		parent::__construct($parent, $args);
		$this->model      = 'Images';
		$this->controller = 'Images';
		$this->args = $args;
		$this->view = "File";



		// $this->content_dir = strtolower(sprintf("/%s/%s",$this->content, $this->model));
	}



	function load_records() {
		parent::load_records();
	}

	function load_view() {
		parent::load_view();
		$this->_parent->view->render();
		// $this->_parent->view->path;
		// test();
		// feedLink();
		// $view->init();
 
	}

}
