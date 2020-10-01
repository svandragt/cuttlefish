<?php

namespace Cuttlefish\Blog;

use Configuration;
use Cuttlefish\Controller;
use Cuttlefish\Filesystem;
use Cuttlefish\Html;

// single post
class ControllerPost extends Controller
{
    /**
     * @return void
     */
    public function records()
    {
        $content_dir = Configuration::CONTENT_FOLDER . '/post/';
        $path = $content_dir . implode('/', $this->args) . '.' . $this->ext;
        $this->records = [ $path ];
    }

    /**
     * @return void
     */
    public function model()
    {
        $this->Model = new ModelPost($this->records);
    }

    /**
     * @return void
     */
    public function view()
    {
        parent::view();

        $this->View = new Html($this->Model->contents, array(
            'layout'     => 'layout.php',
            'controller' => 'post',
            'model'      => 'post',
        ));
    }
}
