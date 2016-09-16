<?php  if ( ! defined('BASE_FILEPATH')) exit('No direct script access allowed');

class ControllerPages extends Controller {

	// single page

	function records() {
		$this->Records = new Collection();
		$this->Records->setCollection(
			array(
	 			Filesystem::url_to_path('/content/pages/' . implode($this->args,"/") . '.' . $this->ext),
 			)
 		);
	}

	function model() {
		$this->Model = new ModelPage( $this->Records->getCollection(), $this->_parent->Environment);
	}

	function view() {
		parent::view();

		$this->View = new Html( $this->Model->contents, array(
			'layout'     => 'single.php',
			'controller' => 'pages',
			'model'      => 'page',
		) ) ;
	}		

}
