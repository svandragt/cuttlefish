<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ControllerErrors extends Controller {

	function __construct($parent, $args) {
		parent::__construct($parent, $args);
		$this->layout     = 'single.php';
		$this->model      = 'page';
		$this->controller = 'errors';
	}
}
