<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Posts extends Model {

	public $model = array(
		'yaml' => 'metadata',
		'markdown|html' => 'content',
	);

	public function sort($a, $b) {
		return strcmp($b->metadata->Published, $a->metadata->Published);
	}

	function load_contents() {
		parent::load_contents();
		$limit = Configuration::POSTS_HOMEPAGE;
    	$this->limit($limit);
	}
	

}