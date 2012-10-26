<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ModelImages extends Model {

	public $model = array();

	public function init() {
 		$this->load_contents();
	}

	function load_contents() {
		$content = $this->_parent->content;
		$controller = strtolower($this->_parent->controller);
		$item       = implode('/', $this->_parent->args);

		$url = "/$content/$controller/$item";
		$this->contents = Filesystem::url_to_path($url);
	}

}