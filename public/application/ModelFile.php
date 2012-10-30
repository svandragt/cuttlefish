<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ModelFile extends Model {

	// todo

	public $model = array();

	

	// function load_contents() {
	// 	$content = $this->_parent->content;
	// 	$controller = strtolower($this->_parent->controller);
	// 	$item       = implode('/', $this->_parent->args);

	// 	$url = "/$content/$controller/$item";
	// 	$this->contents = Filesystem::url_to_path($url);
	// }


	function contents($records, $Environment) {
		foreach ($records as $record) {
			$this->contents[] = $this->list_contents($record, null);
		}
	}

}