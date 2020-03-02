<?php

class ControllerImages extends Cuttlefish\Controller
{
    // single image

    function records()
    {
        $this->records = [ Cuttlefish\Filesystem::url_to_path('/content/images/' . implode($this->args, "/")) ];
    }

    function model()
    {
        $this->Model = new ModelFile($this->records);
    }

    function view()
    {
        parent::view();

        $this->View = new Cuttlefish\File($this->Model->contents);
        $this->View->render();
    }
}
