<?php



use VanDragt\Carbon;

if (!defined('BASE_FILEPATH')) {
    exit('No direct script access allowed');
}

class ControllerErrors extends Carbon\Controller
{

    // single errors page

    function records()
    {
        $this->Records = new Carbon\Collection();
        $this->Records->setCollection(
            array(
                Carbon\Filesystem::url_to_path('/content/errors/' . implode($this->args, "/") . '.' . $this->ext),
            )
        );
    }

    function model()
    {
        $this->Model = new ModelPage($this->Records->getCollection());
    }

    function view()
    {
        parent::view();

        $this->View = new Carbon\Html($this->Model->contents, array(
            'layout' => 'single.php',
            'controller' => 'errors',
            'model' => 'page',
        ));
    }
}
