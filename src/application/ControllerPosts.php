<?php

class ControllerPosts extends Cuttlefish\Controller
{
    // single post

    function records()
    {
        $this->records = [ Cuttlefish\Filesystem::url_to_path('/content/posts/' . implode($this->args, "/") . '.' . $this->ext) ];
    }

    function model()
    {
        $this->Model = new ModelPost($this->records);
    }

    function view()
    {
        parent::view();

        $this->View = new Cuttlefish\Html($this->Model->contents, array(
            'layout'     => 'layout.php',
            'controller' => 'posts',
            'model'      => 'post',
        ));
    }
}
