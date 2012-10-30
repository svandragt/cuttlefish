<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ModelPage extends Model {

	// page model

	public $model = array(
		'markdown|html' => 'content',
	);

	function contents($records, $Environment) {
		$loaded_classes = array(
			'mdep' => ($Environment->class_loaded('MarkdownExtra_Parser')) ? $mdep = new MarkdownExtra_Parser : null,
		);
		foreach ($records as $record) {
			$this->contents[] = $this->list_contents($record, $loaded_classes);
		}
	}

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
