<?php

// single image
class ControllerImages extends Cuttlefish\Controller
{
    public function records()
    {
        $this->records = [ Cuttlefish\Filesystem::convertUrlToPath('/content/images/' . implode('/', $this->args)) ];
    }

    public function model()
    {
        $this->Model = new ModelFile($this->records);
    }

    public function view()
    {
        parent::view();

        $this->View = new Cuttlefish\File($this->Model->contents);
        $this->View->render();
    }
}
