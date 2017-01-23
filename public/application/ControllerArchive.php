<?php



use VanDragt\Carbon;

if (!defined('BASE_FILEPATH')) {
    exit('No direct script access allowed');
}

class ControllerArchive extends Carbon\Controller
{

    // list of recent posts

    function records()
    {
        $this->Records = new Carbon\Files(array('url' => '/content/posts'), $this->ext);
    }

    function model()
    {
        $model = new ModelPost($this->Records->getCollection());
        $this->Model = $model;
    }

    function view()
    {
        parent::view();
        $this->View = new Carbon\Html($this->Model->contents, array(
            'layout' => 'layout.php',
            'controller' => 'archive',
            'model' => 'post',
        ));
    }

}