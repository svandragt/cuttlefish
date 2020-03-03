<?php

// single post
class ControllerPosts extends Cuttlefish\Controller
{
    public function records()
    {
        $url = '/content/posts/' . implode('/', $this->args) . '.' . $this->ext;
        $this->records = [ Cuttlefish\Filesystem::convertUrlToPath($url) ];
    }

    public function model()
    {
        $this->Model = new ModelPost($this->records);
    }

    public function view()
    {
        parent::view();

        $this->View = new Cuttlefish\Html($this->Model->contents, array(
            'layout'     => 'layout.php',
            'controller' => 'posts',
            'model'      => 'post',
        ));
    }
}
