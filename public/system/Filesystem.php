<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Filesystem {

	static function ensure_folder_exists( $folder ) {
		Log::debug(__FUNCTION__ . " called.");
		if ( !is_dir( $folder )) {
			if ( !mkdir( $folder, 0777, true) ) Log::error( "Please manually create <code>$folder</code>" );
			else Log::info("Created $folder");
		}
	}

	static function is_found($file_path) {
		if (is_null($file_path)) throw new Exception('$file_path cannot be null.');
		if (!file_exists ($file_path )) {
			Log::info("'$file_path' cannot be found.");
			Log::debug($file_path . 'NOT found');
			$found = false;
		} else {
			Log::debug($file_path . ' found');
			$found = true;
		}
		return $found;
	}

	static function list_files($dir = ".", $filter = null) { 
		Log::debug(__FUNCTION__ . " called.");
		$files = array();
	   	if ($handle = opendir($dir)) while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$file_path = $dir . DIRECTORY_SEPARATOR . $file;
				if (is_dir($file_path)) {
					$dir_files = self::list_files($file_path, $filter);
					if (count($dir_files) > 0) $files = array_merge($files,$dir_files);
				}
				elseif ((is_null($filter)) || pathinfo($file_path, PATHINFO_EXTENSION) == $filter) $files[] = $file_path;
			}
		}
		closedir($handle);
		return $files;
	}

	static function url_to_path($url) {
		// takes /content/pages/index and returns path
		Log::debug(__FUNCTION__ . " called.");
		$path = BASEPATH . str_replace('/', DIRECTORY_SEPARATOR, $url);
		Log::debug("$url converted to $path");
		return $path;
	} 

	static function file_path_make_relative($absolute_file_path) {
		$root_path = Filesystem::url_to_path('/');
		return str_replace($root_path,"",$absolute_file_path);
	}

	static function remove_files($dir, $is_recursive=false, $is_directory_removable = false) {
		Log::debug(__FUNCTION__ . " called.");
	    foreach(glob($dir . DIRECTORY_SEPARATOR . '*') as $file) {
	        if(is_dir($file) && $is_recursive)
	            self::remove_files($file, $is_recursive, true);
	        else {
	        	echo "Deleted: $file" . "<br>";
	            unlink($file);
	        }
	    }
	    if ($is_directory_removable) rmdir($dir);
	}

	static function copy_files($source_files, $destination_files) {
		Log::debug(__FUNCTION__ . " called.");
		$i = 0;
		foreach ($source_files as $key => $value) {
			$destination_file = $destination_files[$i];

			$dirname = pathinfo ($destination_file, PATHINFO_DIRNAME);
			if (!is_dir($dirname)) mkdir ($dirname, 0777, true);
			copy ( $value , $destination_file );
			echo $destination_file . "<br>";
			$i++;
		}
	}

}
