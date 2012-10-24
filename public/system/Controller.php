<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Controller extends Extension {

	function __construct($parent, $args) {
		parent::__construct($parent, $args);

		$this->content    = Configuration::CONTENT_FOLDER;
		$this->controller = __FUNCTION__;
		$this->ext        = Configuration::CONTENT_EXT;
		$this->layout     = 'layout.php';
		$this->model      = 'posts';
		$this->content_dir = sprintf("/%s/%s",$this->content, $this->model);
		Log::debug(__FUNCTION__ . " called.");
		echo get_class($this);

	}

	public function init() {
		parent::init();
 		$this->load_records();
 		// $this->load_model();
 		


		// // todo: seperate this - see feed Content::loop
		// $data = array();
		// $list_files = Filesystem::list_files( Filesystem::url_to_path($recordlist_url), $ext);
		// rsort($list_files);
		// $i = 0; $max  = Configuration::POSTS_HOMEPAGE;
		// $list_files = array_slice($list_files, 0, $max+5); 
		// foreach ($list_files as $key => $file_path) {
		// 	$data[] = call_user_func ("Model::$model",array(
		// 		'file_path' => $file_path, 
		// 	));	
		// }
		// usort ( $data, "Carbon::compare_published");
		// $data = array_slice($data, 0,$max); 
	}

	public function load_records() {
 		$this->Records = new Records($this->content_dir, $this->ext);
	}

	public function load_model() {
		foreach ($this->Records as $key => $file_path) {
			$data[] = call_user_func ("Model::$model",array(
				'file_path' => $file_path, 
			));	
		}
		// usort ( $data, "Carbon::compare_published");
		// $data = array_slice($data, 0,$max); 

	}


}
	