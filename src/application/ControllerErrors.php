<?php

class ControllerErrors extends Cuttlefish\Controller
{
    // single errors page

    function records()
    {
        $this->records = [ Cuttlefish\Filesystem::url_to_path('/content/errors/' . implode($this->args, "/") . '.' . $this->ext) ];
    }

    function model()
    {
        $this->Model = new ModelPage($this->records);
    }

    function view()
    {
        parent::view();

        $this->View = new Cuttlefish\Html($this->Model->contents, array(
            'layout'     => 'layout.php',
            'controller' => 'errors',
            'model'      => 'page',
        ));
    }
}
