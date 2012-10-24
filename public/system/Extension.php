<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Extension {

	protected $parent;

	function __construct($parent, $args) {
		$this->_parent = $parent;
	}

	function set_parent($parent) {
    	$this->_parent = $parent;
    }

    function init() {
    }
}