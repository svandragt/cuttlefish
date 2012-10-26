<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ControllerArchive extends Controller {

	function __construct($parent, $args) {
		parent::__construct($parent, $args);
		$this->controller = 'archive';
		$this->content_dir = strtolower(sprintf("/%s/%s",$this->content, $this->model));
	}

}