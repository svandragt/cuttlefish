<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Files extends Collection {

	public function __construct($dir_or_path, $ext = null) {
		if (isset($dir_or_path['url'])) {
			$dir_or_path = Filesystem::url_to_path($dir_or_path['url']);
		} elseif (isset($dir_or_path['path'])) {
			$dir_or_path = $dir_or_path['path'];
		}
		$this->setCollection( $this->collect( $dir_or_path, $ext) );
		rsort($this->getCollection());
		return $this;
	}


	private function collect($dir = ".", $filter = null) { 
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

	public function limit($max) {
		$this->setCollection( array_slice($this->getCollection(), 0, $max) ); 
		return $this;
	}	

	public function remove_all($is_directory_removable = false) {
		$output = '';
		Log::debug(__FUNCTION__ . " called.");
	    foreach($this->getCollection() as $file) {
	    		$file = realpath($file);
	        	$output .= "Deleted: $file" . "<br>";
	            unlink($file);
	        
	    }
	    return $output;
	}	

}
