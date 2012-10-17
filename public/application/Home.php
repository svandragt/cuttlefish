<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Home extends Controller {

	function __construct($parent, $args) {
		parent::__construct($parent, $args);
		
		$this->controller = __FUNCTION__;
		$this->model      = 'posts';
		$this->content_dir = sprintf("/%s/%s",$this->content, $this->model);




// -
// -		// todo: seperate this - see feed Content::loop
// -		$data = array();
// -		$list_files = Filesystem::list_files( Filesystem::url_to_path("/$content/$model"), $ext);
// -		rsort($list_files);
// -
// -		$i = 0; $max  = Configuration::POSTS_HOMEPAGE;
// -		$list_files = array_slice($list_files, 0, $max+5); 
// -		foreach ($list_files as $key => $file_path) {
// -			$data[] = call_user_func ("Model::$model",array(
// -				'file_path' => $file_path, 
// -			));	
// -		}
// -		usort ( $data, "Carbon::compare_published");
// -		$data = array_slice($data, 0,$max); 
// -
// -
// -		View::template($data, array(
// -			'layout'     => $layout,
// -			'controller' => $controller,
// -			'model'      => $model,
// -		));

	}

}
