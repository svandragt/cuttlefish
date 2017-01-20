<?php if (!defined('BASE_FILEPATH'))
{
	exit('No direct script access allowed');
}

class ControllerHome extends Controller
{

	// list of recent posts

	function records()
	{
		$limit = Configuration::POSTS_HOMEPAGE;
		$this->Records = new Files(array('url' => '/content/posts'), $this->ext);
		$this->Records->limit($limit + 5);
	}

	function model()
	{
		$model = new ModelPost($this->Records->getCollection(), $this->_parent->Environment);
		$this->Model = $model->limit(Configuration::POSTS_HOMEPAGE);
	}

	function view()
	{
		parent::view();

		$this->View = new Html($this->Model->contents, array(
			'layout'     => 'layout.php',
			'controller' => 'home',
			'model'      => 'post',
		));
	}

}