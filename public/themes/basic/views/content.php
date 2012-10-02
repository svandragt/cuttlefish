<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

echo PHP_EOL;

printf("<div class='%s %s'>", $this->controller, $this->model);

if ( count($this->models) > 1) {
	include __DIR__ . DIRECTORY_SEPARATOR . $this->controller . ".php";
} else {
	include __DIR__ . DIRECTORY_SEPARATOR . $this->model . ".php";
}

print("</div>");
