<?php if (!defined('BASE_FILEPATH')) {
    exit('No direct script access allowed');
}

$post = $this->contents[0]->content;

printf("<article>
	<h2>%s</h2>
	%s
	</article>", $post->title, $post->main);
