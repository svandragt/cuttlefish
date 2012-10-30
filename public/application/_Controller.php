<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Controller {

	static function admin($path_parts) {
		Cache::abort();
		Log::debug(__FUNCTION__ . " called.");

		$action = (isset($path_parts[0])) ? $path_parts[0] : null;
		if ($action != 'new') print('<pre>');

		$return_url = Url::index('/');

		switch ($action) {
			case 'cache':
				Cache::clear();
				break;

			case 'static':
				Cache::generate_site();
				break;

			case 'new':
				Carbon::template_download('post');
				break;

			case 'logout':
				Security::logout();
				break;

			default:
				if (! Security::is_loggedin()) {
					Security::login();
					$return_url = Url::index('/admin');
				}
				else {
					$methods = array(
						'new'    => 'New post template',
						'cache'  => 'Clear cache', 
						'static' => 'Generate static site', 
						'logout' => 'Logout',
					);
					echo "<ul>tasks:";
					foreach ($methods as $key => $value) {
						printf('<li><a href="%s">%s</a></li>', Url::index("/admin/$key"), $value);
					}
					echo "</ul>";
				}
				break;
		}
		printf("<a href='%s'>Return</a></pre>",$return_url);

	}


 	static function themes($path_parts) {
		die('unused');
		$content    = Configuration::CONTENT_FOLDER;
		$controller = __FUNCTION__;
		$ext        = Configuration::CONTENT_EXT;
		$item       = implode('/', $path_parts);
		Log::debug(__FUNCTION__ . " called.");


		$url = Url::index("/$controller/$item");
		$file = Filesystem::url_to_path($url);


		View::file($file, array(
			'controller' => $controller,
		));
 	} 	



}