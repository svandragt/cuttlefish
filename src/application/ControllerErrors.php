<?php

class ControllerErrors extends Cuttlefish\Controller
{
    // single errors page

    /**
     * @return void
     */
    public function records()
    {
        $url = '/content/errors/' . implode("/", $this->args) . '.' . $this->ext;
        $this->records = [ Cuttlefish\Filesystem::convertUrlToPath($url) ];
    }

    /**
     * @return void
     */
    public function model()
    {
        $this->Model = new ModelPage($this->records);
    }

    /**
     * @return void
     */
    public function view()
    {
        parent::view();

        $this->View = new Cuttlefish\Html($this->Model->contents, array(
            'layout'     => 'layout.php',
            'controller' => 'errors',
            'model'      => 'page',
        ));
    }
}
