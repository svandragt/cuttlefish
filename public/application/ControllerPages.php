<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ControllerPages extends Controller {

	function __construct($parent, $args) {
		parent::__construct($parent, $args);
		$this->controller = 'pages';	
		$this->layout     = 'single.php';
		$this->model      = 'page';
		$this->content_url = sprintf("/%s/%ss/%s",$this->content, $this->model, implode($args,"/"));
	}

	function load_records() {
 		$this->Records = new StdClass();
		$this->Records->collection = array(
 			Filesystem::url_to_path($this->content_url .".". $this->ext),
 		);
	}

}
