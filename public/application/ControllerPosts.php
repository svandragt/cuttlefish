
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ControllerPosts extends Controller {

	function __construct($parent, $args) {
		parent::__construct($parent, $args);
		$this->controller = 'posts';
		$this->layout     = 'single.php';
		$this->model      = 'posts';
		$this->content_url = sprintf("/%s/%s/%s",$this->content, $this->controller, implode($args,"/"));
	}


	function load_records() {
 		$this->Records = new StdClass();
		$this->Records->collection = array(
 			Filesystem::url_to_path($this->content_url .".". $this->ext),
 		);
	}

}