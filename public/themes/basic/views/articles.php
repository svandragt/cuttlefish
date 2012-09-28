<?php  if ( ! defined('THEME_DIR')) exit('No direct script access allowed'); 
echo PHP_EOL;

foreach ($this->articles as $key => $article) {
	printf("<article>%s</article>%s", PHP_EOL . $article, PHP_EOL);
}
