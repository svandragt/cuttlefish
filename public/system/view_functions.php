<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

function href($url) {
	$l = new Url();
	return $l->index($url)->url;
}