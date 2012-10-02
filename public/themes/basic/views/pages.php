<?php
$model = $this->models;

printf("<article>
	<h2>%s</h2>
	%s
	</article>", $model->title, $model->content);
