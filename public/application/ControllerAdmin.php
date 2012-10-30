<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ControllerAdmin extends Controller {

	// admin section does not use content files

	public $allowed_methods = array(
		'index'  => 'Overview',
		'draft'  => 'New post template',
		'clear_cache'  => 'Clear cache', 
		'generate' => 'Generate static site', 
		'logout' => 'Logout',
	);

	function init() {
		$this->_parent->Cache->abort();

		$action = (isset($this->args[0])) ? $this->args[0] : 'index';
		if ($this->is_allowed_method($action)) $this->contents = $this->$action();
		else $this->is_allowed_method_fail($action);	
	
		parent::init();

	}

	function view() {
		parent::view();

		$this->View = new Html( $this->contents, array(
			'layout'     => 'single.php',
			'controller' => 'admin',
			'model'      => 'page',
		) ) ;
	}		


	/* admin functionality */

	function is_allowed_method($action) {
		return array_key_exists  ( $action, $this->allowed_methods);
	}

	function is_allowed_method_fail($action) {
		exit("method $action not allowed");
	}

	function index() {
		if ($this->_parent->Security->is_loggedin()) return $this->show_tasks();
		else return $this->show_login();
	}

	function draft() {
		$this->_parent->Security->login_redirect();
		$this->_parent->template_download('post');
	}

	function clear_cache() {
		$this->_parent->Security->login_redirect();
		return $this->_parent->Cache->clear();
	}

	function generate() {
		$this->_parent->Security->login_redirect();
		return $this->_parent->Cache->generate_site();
	}

	function logout() {
		$this->_parent->Security->login_redirect();
		return $this->_parent->Security->logout();
	}

	function show_login() {
		return $this->_parent->Security->login();
	}

	function show_tasks() {
		$output =  '<ul>';
		$am = $this->allowed_methods;
		array_shift($am);
		foreach ($am as $key => $value):
			$url = new Url();
			$output .= sprintf('<li><a href="%s">%s</a></li>', $url->index("/admin/$key")->url, $value);
		endforeach; 

		$output .='</ul>';
		return $output;
	}
	
}
