<?php  if ( ! defined('BASE_FILEPATH')) exit('No direct script access allowed');

class Extension {

	protected $parent;

	function __construct($parent) {
		$this->_parent = $parent;
		// echo get_class($this);
	}

	function set_parent($parent) {
    	$this->_parent = $parent;
    }

}