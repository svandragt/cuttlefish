<?php

// single post
class ControllerPosts extends Cuttlefish\Controller
{
    /**
     * @return void
     */
    public function records()
    {
        $url = '/content/posts/' . implode('/', $this->args) . '.' . $this->ext;
        $this->records = [ Cuttlefish\Filesystem::convertUrlToPath($url) ];
    }

    /**
     * @return void
     */
    public function model()
    {
        $this->Model = new ModelPost($this->records);
    }

    /**
     * @return void
     */
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
