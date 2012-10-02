<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

echo PHP_EOL;

if ( count($this->models) > 1) {
	include __DIR__ . DIRECTORY_SEPARATOR . $this->controller . ".php";
} else {
	include __DIR__ . DIRECTORY_SEPARATOR . $this->model . ".php";
}
