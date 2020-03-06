<?php

class ControllerArchive extends Cuttlefish\Controller
{
    /**
     * @return void
     */
    public function records()
    {
        $Files         = new Cuttlefish\Files(array( 'url' => '/content/posts' ), $this->ext);
        $this->records = $Files->files();
    }

    /**
     * @return void
     */
    public function model()
    {
        $Model       = new ModelPost($this->records);
        $this->Model = $Model;
    }

    /**
     * @return void
     */
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
