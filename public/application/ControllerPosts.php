<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ControllerPosts extends Controller {

	// single post

	function records() {
		$this->Records = new StdClass();
		$this->Records->collection = array(
 			Filesystem::url_to_path('/content/posts/' . implode($this->args,"/") . '.' . $this->ext),
 		);
	}

	function model() {
		$this->Model = new ModelPost( $this->Records->collection, $this->_parent->Environment);
	}

	function view() {
		parent::view();

		$this->View = new Html( $this->Model->contents, array(
			'layout'     => 'single.php',
			'controller' => 'posts',
			'model'      => 'post',
		) ) ;
	}	

}