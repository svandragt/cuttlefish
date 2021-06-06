<?php

foreach ($this->contents as $post) :
    printf("<article>
		<h2><a href='%s'>%s</a></h2>
		%s
		</article>", $post->link, $post->content->title, $post->content->main);
endforeach;
