<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ControllerFeeds extends Controller {

	function __construct($parent, $args) {
		parent::__construct($parent, $args);
		$this->controller = 'feeds';
		$this->model      = 'feed';
		$this->view       = 'feed';
		$this->content_dir = sprintf("/%s/%s",$this->content, $this->args[0]);
	}

	function load_records() {
		parent::load_records();
		$limit = Configuration::POSTS_HOMEPAGE;
    	$this->Records->limit($limit + 5);
	}


	function load_view() {
		parent::load_view();
		$this->_parent->view->render();
	}

}
