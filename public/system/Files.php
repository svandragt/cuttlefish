<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Files {

	function __construct($dir_or_path, $ext = null) {
		if (isset($dir_or_path['url'])) {
			$dir_or_path = Filesystem::url_to_path($dir_or_path['url']);
		} elseif (isset($dir_or_path['path'])) {
			$dir_or_path = $dir_or_path['path'];
		}
		$this->collection = $this->collect( $dir_or_path, $ext);
		rsort($this->collection);
		return $this;
	}





	function limit($max) {
		$this->collection = array_slice($this->collection, 0, $max); 
		return $this;
	}	



	function collect($dir = ".", $filter = null) { 
		Log::debug(__FUNCTION__ . " called.");
		$files = array();
	   	if ($handle = opendir($dir)) while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$file_path = $dir . DIRECTORY_SEPARATOR . $file;
				if (is_dir($file_path)) {
					$dir_files = $this->collect($file_path, $filter);
					if (count($dir_files) > 0) $files = array_merge($files,$dir_files);
				}
				elseif ((is_null($filter)) || pathinfo($file_path, PATHINFO_EXTENSION) == $filter) $files[] = $file_path;
			}
		}
		closedir($handle);
		return $files;
	}

	function remove_files($is_directory_removable = false) {
		$output = '';
		Log::debug(__FUNCTION__ . " called.");
	    foreach($this->collection as $file) {
	    		$file = realpath($file);
	        	$output .= "Deleted: $file" . "<br>";
	            unlink($file);
	        
	    }
	    return $output;
	}	

	function sort_by_function($function) {
		usort ( $this->collection, $function);

	}

}
