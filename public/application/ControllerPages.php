<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ControllerPages extends Controller {

	function __construct($parent, $args) {
		parent::__construct($parent, $args);
		$this->layout     = 'single.php';
		$this->model      = 'Pages';
		$this->controller = 'Pages';	

	}

}
