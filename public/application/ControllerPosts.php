<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ControllerPosts extends Controller {

	function __construct($parent, $args) {
		parent::__construct($parent, $args);
		$this->content_dir = strtolower(sprintf("/%s/%s",$this->content, $this->model));
		$this->controller = 'Posts';
		$this->layout     = 'single.php';
		
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