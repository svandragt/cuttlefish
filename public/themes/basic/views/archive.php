<?php if (!defined('BASE_FILEPATH'))
{
	exit('No direct script access allowed');
}

echo '<h2>Archive</h2><dl>';

foreach ($this->contents as $post):
	printf("<dt>%s</dt><dd><a href='%s'>%s</a></h2></dd>", $post->metadata->Published, $post->link, $post->content->title);
endforeach;

echo '</dl>';