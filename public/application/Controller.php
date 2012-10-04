<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Controller {

	static function admin($path_parts) {
		Cache::abort();
		$action = (isset($path_parts[0])) ? $path_parts[0] : null;
		if ($action != 'new') print('<pre>');

		switch ($action) {
			case 'cache':
				Cache::clear();
				break;

			case 'static':
				Cache::clear();
				Cache::generate_site();
				break;


			case 'new':
				Carbon::template('post');
				break;

			case 'logout':
				Security::logout();
				break;

			default:
				if (! Security::is_loggedin()) Security::login();
				else {
					$methods = array(
						'new' => 'New post template',
						'cache' => 'Clear cache', 
						'static' => 'Generate static site', 
						'logout' => 'Logout');
					echo "<ul>tasks:";
					foreach ($methods as $key => $value) {
						printf('<li><a href="%s">%s</a></li>',Url::content_url("/admin/$key"), $value);						
					}
					echo "</ul>";

				}
				break;
		}
		printf("<a href='%s'>Return</a><br>",Url::content_url('/'));
		print('</pre>');

	}

	static function errors($path_parts) {
		$content    = Configuration::CONTENT_FOLDER;
		$controller = __FUNCTION__;
		$ext        = Configuration::CONTENT_EXT;
		$layout     = 'single.php';
		$model      = 'pages';

		header("HTTP/1.0 404 Not Found");
		$item = $path_parts[0];
		switch ($item) {
			case '404':
				$file_path = Filesystem::url_to_path("/$content/$controller/$item.$ext");
				$data      =  (file_exists($file_path)) ? call_user_func ("Model::$model",array(
					'file_path' => $file_path,
				)) : "Sorry, this page does not exists (404). Customise this page by adding a /$content/$controller/$item.$ext.";
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

		$data = array();
		$i    = 0;
		$max  = Configuration::POSTS_HOMEPAGE;
		foreach (Filesystem::list_files( Filesystem::url_to_path("/$content/$model"), $ext) as $key => $value) {
			$data[] = call_user_func ("Model::$model",array(
				'file_path' => $value, 
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

		$url = Url::content_url("/$controller/$item");
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

		$url = Url::content_url("/$content/$controller/$item");
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

		$data = array();
		$i    = 0;
		$max  = Configuration::POSTS_HOMEPAGE;
		foreach (Filesystem::list_files( Filesystem::url_to_path("/$content/$model"), $ext) as $key => $value) {
			$data[] = call_user_func ("Model::$model",array(
				'file_path' => $value, 
			));	
			if (++$i == $max) break;
		}
		usort ( $data, "Carbon::compare_published");
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

		$data = array();
		foreach (Filesystem::list_files( Filesystem::url_to_path("/$content/$model"), $ext) as $key => $value) {
			$data[] = call_user_func ("Model::$model",array(
				'file_path' => $value, 
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

		$item       = implode('/', $path_parts);
		$file_path  = Filesystem::url_to_path("/$content/$model/$item.$ext");
		$data       = call_user_func ("Model::$model",array(
				'file_path' => $file_path, 
		));	

		View::template($data, array(
			'layout'     => $layout,
			'controller' => $controller,
			'model'      => $model,
		));
	}
}