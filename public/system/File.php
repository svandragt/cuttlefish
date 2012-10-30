<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class File {

	public $is_relative;
	public $path;
	
	function __construct($file_path)
	{

		$file_path = (is_array($file_path)) ? implode($file_path, " ") : $file_path;
		try {
			if (! file_exists($file_path)) throw new Exception("'$file_path' not found");
			if (! is_readable($file_path)) throw new Exception("'$file_path' is unreadable!");
		} catch (Exception $e) {
			Log::debug($e->getMessage());		
			Log::error($e->getMessage());		
			exit();			
		}
		$this->path = $file_path; 
		$this->ext = pathinfo ( $file_path , PATHINFO_EXTENSION);
		$this->mime = $this->mime();
	}

	function relative() {
		if (!$this->is_relative) {
			$root_path = Filesystem::url_to_path('/');
			$this->path = str_replace($root_path,"",$this->path);
			$this->is_relative = true;
		}
		return $this;
	}

	function render() {
		$mime = $this->mime;
		header("Content-Type: $mime");
		readfile($this->path);
	}

	function mime() {
		switch ($this->ext) {
			case 'css': // php cannot detect css
				return "text/css";
				break;
			
			default:
				return mime_content_type($this->path);
				break;
		}
	}
}