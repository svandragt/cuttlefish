<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

echo PHP_EOL;
if ( count($this->models) > 1) foreach ($this->models as $model) {
	printf("<article>
		<h2><a href='%s'>%s</a></h2>
		%s
		</article>", $model->link, $model->title, $model->content);
} else {
	$model = $this->models[0];

	switch ($model->caller['function']) {
		case 'pages':
			printf("<article>
				<h2>%s</h2>
				%s
				</article>", $model->title, $model->content);
			# code...
			break;
		
		case 'posts':
			printf("<article>
				<h2>%s</h2>
				<small>%s</small>
				%s
				</article>", $model->title, $model->metadata->Published, $model->content);
			break;
		default:
			# code...
			break;
	}

}
