<?php  if ( ! defined('BASE_FILEPATH')) exit('No direct script access allowed');

class ControllerImages extends Controller {

	// single image

	function records() {
		$this->Records = new Collection();
		$this->Records->setCollection( 
			array(
	 			Filesystem::url_to_path('/content/images/' . implode($this->args,"/")),
 			)
 		);
	}

	function model() {
		$this->Model = new ModelFile( $this->Records->getCollection(), $this->_parent->Environment);
	}

	function view() {
		parent::view();

		$this->View = new File( $this->Model->contents );
		$this->View->render();
	}		

}
