<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ControllerImages extends Controller {

	// single image

	function records() {
		$this->Records = new StdClass();
		$this->Records->collection = array(
 			Filesystem::url_to_path('/content/images/' . implode($this->args,"/")),
 		);
	}

	function model() {
		$this->Model = new ModelFile( $this->Records->collection, $this->_parent->Environment);
	}

	function view() {
		parent::view();

		$this->View = new File( $this->Model->contents, array(
			'layout'     => 'single.php',
			'controller' => 'images',
			'model'      => 'file',
		) ) ;
	}		

}
