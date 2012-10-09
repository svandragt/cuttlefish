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

	static function errors($path_parts) {
		$content    = Configuration::CONTENT_FOLDER;
		$controller = __FUNCTION__;
		$ext        = Configuration::CONTENT_EXT;
		$layout     = 'single.php';
		$model      = 'pages';
		Log::debug(__FUNCTION__ . " called.");


		header("HTTP/1.0 404 Not Found");
		$item = $path_parts[0];
		switch ($item) {
			case '404':
				$file_path = Filesystem::url_to_path("/$content/$controller/$item.$ext");
				$data      =  (file_exists($file_path)) ? call_user_func ("Model::$model", 
					array(
					'file_path' => $file_path,
					)) : "Sorry, this page does not exists (404). 
				Customise this page by adding a /$content/$controller/$item.$ext.";
				
				View::template($data, array(
						'layout'     => $layout,
						'controller' => $controller,
						'model'      => $model,
				));
			break;
		}
 	}

 	static function feed() {
		$content    = Configuration::CONTENT_FOLDER;
		$controller = __FUNCTION__;
		$ext        = Configuration::CONTENT_EXT;
		$model      = 'posts';
		Log::debug("$controller called.");


		$data = array();
		$i    = 0;
		$max  = Configuration::POSTS_HOMEPAGE;
		foreach (Filesystem::list_files( Filesystem::url_to_path("/$content/$model"), $ext) as $key => $file_path) {
			$data[] = call_user_func ("Model::$model", array(
				'file_path' => $file_path, 
			));	
			if (++$i == $max) break;
		}
		usort ( $data, "Carbon::compare_published");

		View::feed($data, array(
			'filename' => $controller,
		));
	
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


	static function images($path_parts) {
		$content    = Configuration::CONTENT_FOLDER;
		$controller = __FUNCTION__;
		$ext        = Configuration::CONTENT_EXT;
		$item       = implode('/', $path_parts);
		Log::debug(__FUNCTION__ . " called.");

		$url = "/$content/$controller/$item";
		$file = Filesystem::url_to_path($url);

		View::file($file, array(
			'controller' => $controller,
		));
 	} 	


	static function index() {
		$content    = Configuration::CONTENT_FOLDER;
		$controller = __FUNCTION__;
		$ext        = Configuration::CONTENT_EXT;
		$layout     = 'layout.php';
		$model      = 'posts';
		Log::debug(__FUNCTION__ . " called.");

		$data = array();
		$i    = 0;
		$max  = Configuration::POSTS_HOMEPAGE;
		$list_files = Filesystem::list_files( Filesystem::url_to_path("/$content/$model"), $ext);
		rsort($list_files);
		$list_files = array_slice($list_files, 0,$max+5); 
		foreach ($list_files as $key => $file_path) {
			$data[] = call_user_func ("Model::$model",array(
				'file_path' => $file_path, 
			));	
		}
		usort ( $data, "Carbon::compare_published");
		$data = array_slice($data, 0,$max); 


		View::template($data, array(
			'layout'     => $layout,
			'controller' => $controller,
			'model'      => $model,
		));
	}

	static function archive() {
		$content    = Configuration::CONTENT_FOLDER;
		$controller = __FUNCTION__;
		$ext        = Configuration::CONTENT_EXT;
		$layout     = 'single.php';
		$model      = 'posts';
		Log::debug(__FUNCTION__ . " called.");


		$data = array();
		foreach (Filesystem::list_files( Filesystem::url_to_path("/$content/$model"), $ext) as $key => $file_path) {
			$data[] = call_user_func ("Model::$model",array(
				'file_path' => $file_path, 
			));	
		}
		usort ( $data, "Carbon::compare_published");

		View::template($data, array(
			'layout'     => $layout,
			'controller' => $controller,
			'model'      => $model,
		));
	}

	
	static function pages($path_parts) {
		$content    = Configuration::CONTENT_FOLDER;
		$controller = __FUNCTION__;
		$ext        = Configuration::CONTENT_EXT;
		$layout     = 'layout.php';
		$model      = $controller;
		Log::debug(__FUNCTION__ . " called.");


		$item      = $path_parts[0];
		$file_path = Filesystem::url_to_path("/$content/$model/$item.$ext");
		$data      = call_user_func ("Model::$model",array(
				'file_path' => $file_path, 
		));	

		View::template($data, array(
			'layout'     => $layout,
			'controller' => $controller,
			'model'      => $model,
		));
	}

	static function posts($path_parts) {
		$content    = Configuration::CONTENT_FOLDER;
		$controller = __FUNCTION__;
		$ext        = Configuration::CONTENT_EXT;
		$layout     = 'layout.php';
		$model      = $controller;
		Log::debug(__FUNCTION__ . " called.");


		$item       = implode('/', $path_parts);
		$file_path  = Filesystem::url_to_path("/$content/$model/$item.$ext");
		$data       = call_user_func ("Model::$model", array(
				'file_path' => $file_path, 
		));	

		View::template($data, array(
			'layout'     => $layout,
			'controller' => $controller,
			'model'      => $model,
		));
	}
}