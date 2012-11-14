<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ControllerArchive extends Controller {

	// list of recent posts

	function records() {
 		$this->Records = new Files(array('url'=> '/content/posts'), $this->ext);
	}

	function model() {
		$model = new ModelPost( $this->Records->collection, $this->_parent->Environment);
		$this->Model = $model;
	}

	function view() {
		parent::view();
		$this->View = new Html( $this->Model->contents, array(
			'layout'     => 'layout.php',
			'controller' => 'archive',
			'model'      => 'post',
		) ) ;
	}	

}