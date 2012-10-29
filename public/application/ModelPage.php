<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ModelPage extends Model {

	public $model = array(
		'markdown|html' => 'content',
	);

}

		// header("HTTP/1.0 404 Not Found");
		// $item = $path_parts[0];
		// switch ($item) {
		// 	case '404':
		// 		$file_path = Filesystem::url_to_path("/$content/$controller/$item.$ext");
		// 		$data      =  (file_exists($file_path)) ? call_user_func ("Model::$model", 
		// 			array(
		// 			'file_path' => $file_path,
		// 			)) : "Sorry, this page does not exists (404). 
		// 		Customise this page by adding a /$content/$controller/$item.$ext.";
				
		// 		View::template($data, array(
		// 				'layout'     => $layout,
		// 				'controller' => $controller,
		// 				'model'      => $model,
		// 		));
		// 	break;
		// }
 	// }
