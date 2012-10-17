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


	}

	public function init() {
		print_r($this->load_records($this->content_dir));	
	}

	public function load_records($content_dir) {
 		return new Records($content_dir, $this->ext);		
		// $recordlist_url = sprintf("/%s/%s",$this->content, $this->model);
		// $records = new Records($recordlist_url);	
		// $this->_parent->Records = $records;

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


}
	