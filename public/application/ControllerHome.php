<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ControllerHome extends Controller {

	function __construct($parent, $args) {
		parent::__construct($parent, $args);
		$this->controller = 'home';
		$this->content_dir = sprintf("/%s/%s",$this->content, $this->model);
	}

	function load_records() {
		parent::load_records();
		$limit = Configuration::POSTS_HOMEPAGE;
    	$this->Records->limit($limit + 5);
	}

}