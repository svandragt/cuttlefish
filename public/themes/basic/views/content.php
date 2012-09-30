<?php  if ( ! defined('THEME_DIR')) exit('No direct script access allowed'); 
echo PHP_EOL;

foreach ($this->content as $key => $item) {
	printf("<article>%s</article>%s", PHP_EOL . $item, PHP_EOL);
}
