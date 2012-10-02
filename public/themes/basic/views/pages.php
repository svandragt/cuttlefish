<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$model = $this->models;

printf("<article>
	<h2>%s</h2>
	%s
	</article>", $model->title, $model->content);
