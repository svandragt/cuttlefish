<?php

namespace Cuttlefish\Blog;

use Configuration;
use Cuttlefish\Controller;
use Cuttlefish\Files;
use Cuttlefish\Html;

class ControllerArchive extends Controller
{
    /**
     * @return void
     */
    public function records()
    {
        $content_dir = Configuration::CONTENT_FOLDER  . '/posts';
        $Files         = new Files(array( 'url' => $content_dir ), $this->ext);
        $this->records = $Files->files();
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
            'controller' => 'archive',
            'model'      => 'post',
        ));
    }
}
