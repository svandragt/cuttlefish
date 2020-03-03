<?php

class ControllerArchive extends Cuttlefish\Controller
{
    public function records()
    {
        $Files         = new Cuttlefish\Files(array( 'url' => '/content/posts' ), $this->ext);
        $this->records = $Files->files();
    }

    public function model()
    {
        $Model       = new ModelPost($this->records);
        $this->Model = $Model;
    }

    public function view()
    {
        parent::view();
        $this->View = new Cuttlefish\Html($this->Model->contents, array(
            'layout'     => 'layout.php',
            'controller' => 'archive',
            'model'      => 'post',
        ));
    }
}
