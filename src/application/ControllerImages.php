<?php

// single image
class ControllerImages extends Cuttlefish\Controller
{
    /**
     * @return void
     */
    public function records()
    {
        $this->records = [ Cuttlefish\Filesystem::convertUrlToPath('/content/images/' . implode('/', $this->args)) ];
    }

    /**
     * @return void
     */
    public function model()
    {
        $this->Model = new ModelFile($this->records);
    }

    /**
     * @return void
     */
    public function view()
    {
        parent::view();

        $this->View = new Cuttlefish\File($this->Model->contents);
        $this->View->render();
    }
}
