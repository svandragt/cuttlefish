<?php  if ( ! defined('THEME_DIR')) exit('No direct script access allowed'); 

foreach ($this->articles as $key => $article) {
	printf("<article>%s</article>", $article);
}
