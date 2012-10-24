<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Files {

	function __construct($content_dir, $ext) {
		$this->collection = $this->list_files( Filesystem::url_to_path($content_dir), $ext);
		rsort($this->collection);
		return $this;
	}





	function limit($max) {
		$this->collection = array_slice($this->collection, 0, $max); 
		return $this;
	}	



	function list_files($dir = ".", $filter = null) { 
		Log::debug(__FUNCTION__ . " called.");
		$files = array();
	   	if ($handle = opendir($dir)) while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$file_path = $dir . DIRECTORY_SEPARATOR . $file;
				if (is_dir($file_path)) {
					$dir_files = $this->list_files($file_path, $filter);
					if (count($dir_files) > 0) $files = array_merge($files,$dir_files);
				}
				elseif ((is_null($filter)) || pathinfo($file_path, PATHINFO_EXTENSION) == $filter) $files[] = $file_path;
			}
		}
		closedir($handle);
		return $files;
	}

	function file_path_make_relative($absolute_file_path) {
		$root_path = Filesystem::url_to_path('/');
		return str_replace($root_path,"",$absolute_file_path);
	}

	function remove_files($dir, $is_recursive=false, $is_directory_removable = false) {
		Log::debug(__FUNCTION__ . " called.");
	    foreach(glob($dir . DIRECTORY_SEPARATOR . '*') as $file) {
	        if(is_dir($file) && $is_recursive)
	            $this->remove_files($file, $is_recursive, true);
	        else {
	        	echo "Deleted: $file" . "<br>";
	            unlink($file);
	        }
	    }
	    if ($is_directory_removable) rmdir($dir);
	}	

	function sort_by_function($function) {
		usort ( $this->collection, $function);

	}

}
