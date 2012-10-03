<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$model = $this->models;

printf("<article>
	<h2>%s</h2>
	<small>%s</small>
	%s
	</article>", $model->title, $model->metadata->Published, $model->content);
