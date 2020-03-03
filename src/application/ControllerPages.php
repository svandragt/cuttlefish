<?php

// single page
class ControllerPages extends Cuttlefish\Controller
{
    public function records()
    {
        $url = '/content/pages/' . implode($this->args, "/") . '.' . $this->ext;
        $this->records = [ Cuttlefish\Filesystem::convertUrlToPath($url) ];
    }

    public function model()
    {
        $this->Model = new ModelPage($this->records);
    }

    public function view()
    {
        parent::view();

        $this->View = new Cuttlefish\Html($this->Model->contents, array(
            'layout'     => 'layout.php',
            'controller' => 'pages',
            'model'      => 'page',
        ));
    }
}
