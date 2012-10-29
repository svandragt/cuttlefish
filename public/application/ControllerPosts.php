
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ControllerPosts extends Controller {

	// single post

	function __construct($parent, $args) {
		parent::__construct($parent, $args);
		$this->layout     = 'single.php';
		$this->controller = 'posts';
		$this->model      = 'post';
		$this->record_url = sprintf("/%s/%ss/%s",$this->content, $this->model, implode($args,"/"));
	}


	function load_records() {
 		$this->Records = new StdClass();
		$this->Records->collection = array(
 			Filesystem::url_to_path($this->record_url .".". $this->ext),
 		);
	}

}