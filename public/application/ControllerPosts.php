<?php



use VanDragt\Carbon;

if (!defined('BASE_FILEPATH')) {
    exit('No direct script access allowed');
}

class ControllerPosts extends Carbon\Controller
{

    // single post

    function records()
    {
        $this->Records = new Carbon\Collection();
        $this->Records->setCollection(
            array(
                Carbon\Filesystem::url_to_path('/content/posts/' . implode($this->args, "/") . '.' . $this->ext),
            )
        );
    }

    function model()
    {
        $this->Model = new ModelPost($this->Records->getCollection());
    }

    function view()
    {
        parent::view();

        $this->View = new Carbon\Html($this->Model->contents, array(
            'layout' => 'single.php',
            'controller' => 'posts',
            'model' => 'post',
        ));
    }

}