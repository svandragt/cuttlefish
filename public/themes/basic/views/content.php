<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

printf("<div class='%s %s'>", $this->controller, $this->model);

switch (count($this->models)) {
	case 0:
		// no content - new installation
		printf("<p> Please <a href='%s'>add content</a> to /%s/%s.</p>", Url::content_url('/admin/new'), Configuration::CONTENT_FOLDER, $this->model);
		break;
	
	case 1:
		// single piece of content (ie individual page/post)
		include __DIR__ . DIRECTORY_SEPARATOR . $this->model . ".php";
		break;
	
	default:
		// 2 or more pieces of content (loop - ie. index/archive)
		include __DIR__ . DIRECTORY_SEPARATOR . $this->controller . ".php";
		break;
}

print("</div>");
