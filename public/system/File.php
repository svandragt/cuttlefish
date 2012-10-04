<?php

class File {
	
	function __construct($file_path)
	{
		if (! file_exists($file_path)) die("$file_path not found");
		// if (! file_exists($file_path)) header('Location: ' . Theming::root() . Theming::content_url('/errors/404'));
		if (! is_readable($file_path)) throw new Exception("$file_path is unreadable!");
		$this->path = $file_path; 
		$this->ext = pathinfo ( $file_path , PATHINFO_EXTENSION);
		$this->mime = $this->mime();
	}

	function output() {
		$mime = $this->mime;
		header('Cache-Control: public'); 
		header("Content-Type: $mime");
		readfile($this->path);
	}

	function mime() {
		switch ($this->ext) {
			case 'css':
				return "text/css";
				break;
			
			default:
				return mime_content_type($this->path);
				break;
		}
	}
}