<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$content = $this->contents;

printf("<article>
	<h2>%s</h2>
	<small>%s</small>
	%s
	</article>", $content->title, $content->metadata->Published, $content->content);
