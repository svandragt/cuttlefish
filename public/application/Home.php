<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Home extends Controller {

	function __construct($parent, $args) {
		parent::__construct($parent, $args);
		$this->content_dir = sprintf("/%s/%s",$this->content, $this->model);
	}

	function load_records() {
		parent::load_records();
		echo 'test';
		$limit = Configuration::POSTS_HOMEPAGE;
    	$this->Records->limit($limit + 5);
	}

	static function sortby_published($a,$b) {
    	return strcmp($b->metadata->Published, $a->metadata->Published);
	}

}

// print_r($this->Records);
// $sort = array(__CLASS__,'sortby_published');
// ->sort_by_function($sort)->limit($limit)

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
