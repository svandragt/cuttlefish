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

	function init() {
		$this->_parent->Cache->abort();
		$action = (isset($this->args[0])) ? $this->args[0] : 'index';

		$url = new Url();
		$this->return_url = $url->index('/');
		
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
		if (! $this->_parent->Security->is_loggedin()) {
		$url = new Url();
			$this->_parent->Security->login();
			$this->return_url = $url->index('/admin');
		}
		else {
			array_shift($this->allowed_methods);
			$am = $this->allowed_methods;
			echo "<ul>tasks:";
			foreach ($am as $key => $value) {
				$url = new Url();
				printf('<li><a href="%s">%s</a></li>', $url->index("/admin/$key")->url, $value);
			}
			echo "</ul>";
		
		}

	}

	function draft() {
		$this->_parent->template_download('post');
	}

	function clear_cache() {
		$this->_parent->Security->login_redirect();
		$dir =  BASEPATH . DIRECTORY_SEPARATOR . str_replace("/", DIRECTORY_SEPARATOR, Configuration::CACHE_FOLDER);
		$dir = realpath($dir);
		printf("Removing  all files in %s<br>", $dir);
		$files = new Files(array('path' => $dir));
		$files->remove_files();
		// todo - remove emptyy directories but not the directory - http://stackoverflow.com/questions/1833518/remove-empty-subfolders-with-php
	}

	function generate() {
		$this->_parent->Cache->generate_site();
	}

	function logout() {
		$this->_parent->Security->logout();
	}




	
// 		printf("<a href='%s'>Return</a></pre>",$return_url);		
	
}
