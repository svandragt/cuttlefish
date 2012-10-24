<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Posts extends Model {

	public static $model = array(
		'yaml' => 'metadata',
		'markdown|html' => 'content',
	);

	function __construct($parent) {
		parent::__construct($parent);	
	}

}