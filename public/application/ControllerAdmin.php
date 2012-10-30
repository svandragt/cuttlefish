<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ControllerAdmin extends Controller {

	public $allowed_methods = array(
		'index'  => 'Overview',
		'draft'  => 'New post template',
		'clear_cache'  => 'Clear cache', 
		'generate' => 'Generate static site', 
		'logout' => 'Logout',
	);


	function __construct($parent, $args) {
		parent::__construct($parent, $args);
		$this->layout     = 'single.php';
		$this->model      = 'page';
		$this->controller = 'Admin';
	}

	function __destruct() {
		echo sprintf("<a href='%s'>%s</a>", $this->return_url, "Return");
	}

	function init() {
		$this->_parent->Cache->abort();
		$action = (isset($this->args[0])) ? $this->args[0] : 'index';

		$url = new Url();
		$this->return_url = $url->index('/')->url;
		
		if ($this->is_allowed_method($action)) $this->$action();
		else $this->is_allowed_method_fail($action);

	}

	function is_allowed_method($action) {
		return array_key_exists  ( $action, $this->allowed_methods);
	}

	function is_allowed_method_fail($action) {
		exit("method $action not allowed");
	}

	function index() {
		if ($this->_parent->Security->is_loggedin()) $this->show_tasks();
		else $this->show_login();
	}

	function draft() {
		$this->_parent->Security->login_redirect();
		$this->_parent->template_download('post');
	}

	function clear_cache() {
		$this->_parent->Security->login_redirect();
		$this->_parent->Cache->clear();
	}

	function generate() {
		$this->_parent->Security->login_redirect();
		$this->_parent->Cache->generate_site();
	}

	function logout() {
		$this->_parent->Security->login_redirect();
		$this->_parent->Security->logout();
	}

	function show_login() {
		$this->_parent->Security->login();
		$url = new Url();
		$this->return_url = $url->index('/admin')->url;
	}

	function show_tasks() {
		array_shift($this->allowed_methods);
		$am = $this->allowed_methods;
		echo "<ul>tasks:";
		foreach ($am as $key => $value) {
			$url = new Url();
			printf('<li><a href="%s">%s</a></li>', $url->index("/admin/$key")->url, $value);
		}
		echo "</ul>";
	}




	
// 		printf("<a href='%s'>Return</a></pre>",$return_url);		
	
}
