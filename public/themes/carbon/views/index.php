<?php

foreach ($this->models as $model) {
	printf("<article>
		<h2><a href='%s'>%s</a></h2>
		%s
		</article>", $model->link, $model->title, $model->content);
} 
echo "<p><a href='" . Theming::root() . "/archive'>&#171; Older articles</a></p>";
