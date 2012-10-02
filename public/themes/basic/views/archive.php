<?php
echo '<h2>Archive</h2><dl>';

foreach ($this->models as $model) {
	printf("<dt>%s</dt><dd><a href='%s'>%s</a></h2></dd>", $model->metadata->Published, $model->link, $model->title);
} 

echo '</dl>';