<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ControllerFeeds extends Controller {

	// single feed

	function records() {
		$limit = Configuration::POSTS_HOMEPAGE;
 		$this->Records = new Files(array('url'=> '/content/posts'), $this->ext);
    	$this->Records->limit($limit + 5); 		
	}

	function model() {
		$this->Model = new ModelPost( $this->Records->collection, $this->_parent->Environment);
	}

	function view() {
		parent::view();

		$this->View = new Feed( $this->Model->contents, array(
			'controller' => 'feeds',
			'model'      => 'feed',
		) ) ;
	}		


}
