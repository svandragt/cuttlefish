<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ControllerImages extends Controller {

	function __construct($parent, $args) {
		parent::__construct($parent, $args);
		$this->model      = 'Images';
		$this->controller = 'Images';
		$this->view = 'File';
	}

	function load_view() {
		parent::load_view();
		$this->_parent->view->render();
	}

}
