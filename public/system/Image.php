<?php

class Image {
	
	function __construct($file_path)
	{
        if (! file_exists($file_path)) header('Location: ' . Theming::root() . Theming::content_url('/errors/404'));
        if (! is_readable($file_path)) throw new Exception("$file_path is unreadable!");
        $this->file_path = $file_path; 
        $this->mime = mime_content_type($file_path);
	}

	function output() {
        $mime = $this->mime;
        header('Cache-Control: public'); 
        header("Content-Type: $mime");
        readfile($this->file_path);
	}
}