<?php
echo '<h2>Archive</h2><ul>';

foreach ($this->models as $model) {
	printf("<li><a href='%s'>%s</a></h2></li>", $model->link, $model->title);
} 

echo '</ul>';