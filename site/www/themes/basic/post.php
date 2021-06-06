<?php

if (! defined('BASE_DIR')) {
    exit('No direct script access allowed');
}

$post = $this->contents[0];
printf(
    "<article>
	<h2>%s</h2>
	<small>%s</small>
	%s
	</article>",
    $post->content->title,
    $post->metadata->published,
    $post->content->main
);
