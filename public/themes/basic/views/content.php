<?php  if ( ! defined('THEME_DIR')) exit('No direct script access allowed'); 
echo PHP_EOL;

foreach ($this->models as $model) {
	printf("<article>
		<h2><a href='%s'>%s</a></h2>
		%s
		</article>", $model->link, $model->title, $model->content);
}
