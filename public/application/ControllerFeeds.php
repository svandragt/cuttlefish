<?php  if ( ! defined('BASE_FILEPATH')) exit('No direct script access allowed');

class ControllerFeeds extends Controller {

	// single feed

	function records() {
		$limit = Configuration::POSTS_HOMEPAGE;
		$records = new Files(array('url'=> '/content/posts'), $this->ext);
		$this->Records = $records->limit($limit + 5); 		
	}

	function model() {
		$model = new ModelPost( $this->Records->getCollection(), $this->_parent->Environment);
		$this->Model = $model->limit(10);
	}

	function view() {
		parent::view();
		$this->View = new Feed( $this->Model->contents ) ;
	}		
}
