<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

echo PHP_EOL;

if ($this->controller == 'archive') echo '<h2>Archive</h2><ul>';

if ( count($this->models) > 1) {

	foreach ($this->models as $model) {
		switch ($this->controller) {
			case 'index':
				printf("<article>
					<h2><a href='%s'>%s</a></h2>
					%s
					</article>", $model->link, $model->title, $model->content);
				break;
			
			case 'archive':
			printf("<li><a href='%s'>%s</a></h2></li>", $model->link, $model->title);
				break;

			default:
				# code...
				break;
		}
	} 
}else {
	$model = $this->models[0];

	switch ($model->model['function']) {
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

if ($this->controller == 'archive') echo '</ul>';
