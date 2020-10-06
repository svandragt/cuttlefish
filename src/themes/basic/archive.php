<?php

if (! defined('BASE_DIR')) {
    exit('No direct script access allowed');
}
?>

<h2>Archive</h2>
<dl>

    <?php foreach ($this->contents as $post) :
        printf(
            "<dt>%s</dt><dd><a href='%s'>%s</a></h2></dd>",
            $post->metadata->published,
            $post->link,
            $post->content->title
        );
    endforeach;
    ?>

</dl>
