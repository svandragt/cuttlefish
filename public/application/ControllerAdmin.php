<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ControllerAdmin extends Controller {

	function __construct($parent, $args) {
		parent::__construct($parent, $args);
		$this->layout     = 'single.php';
		$this->model      = 'page';
		$this->controller = 'Admin';
	}

	function init() {
		$this->_parent->Cache->abort();
		$action = (isset($this->args[0])) ? $this->args[0] : null;
// 		if ($action != 'new') print('<pre>');

// 		$return_url = Url::index('/');

		switch ($action) {
			case 'cache':
				$this->_parent->Cache->clear();
				break;

			case 'static':
				$this->_parent->Cache->generate_site();
				break;

			case 'new':
				$this->_parent->template_download('post');
				break;

			case 'logout':
				//  todo Security::logout();
				break;

			default:
				// if (! Security::is_loggedin()) {
				// 	Security::login();
				// 	$return_url = Url::index('/admin');
				// }
				// else {
				// 	$methods = array(
				// 		'new'    => 'New post template',
				// 		'cache'  => 'Clear cache', 
				// 		'static' => 'Generate static site', 
				// 		'logout' => 'Logout',
				// 	);
				// 	echo "<ul>tasks:";
				// 	foreach ($methods as $key => $value) {
				// 		printf('<li><a href="%s">%s</a></li>', Url::index("/admin/$key"), $value);
				// 	}
				// 	echo "</ul>";
				// }
				break;
		}
// 		printf("<a href='%s'>Return</a></pre>",$return_url);		
	}
}
