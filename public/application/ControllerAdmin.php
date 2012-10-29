<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ControllerAdmin extends Controller {

	public $allowed_methods = array(
		'index'  => 'overview',
		'draft'  => 'New post template',
		'cache'  => 'Clear cache', 
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
			$this->_parent->Security->login();
			$url = new Url();
			$this->return_url = $url->index('/admin');
		}
		else {
		// 	echo "<ul>tasks:";
		// 	foreach ($methods as $key => $value) {
		// 		printf('<li><a href="%s">%s</a></li>', Url::index("/admin/$key"), $value);
		// 	}
		// 	echo "</ul>";
		// }
		}

	}

	function draft() {
		$this->_parent->template_download('post');
	}

	function cache() {
		$this->_parent->Cache->clear();
	}

	function generate() {
		$this->_parent->Cache->generate_site();
	}

	function logout() {
		$this->_parent->Security->logout();
	}




	
// 		printf("<a href='%s'>Return</a></pre>",$return_url);		
	
}
