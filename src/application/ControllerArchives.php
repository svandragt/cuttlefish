<?php

namespace Cuttlefish\Blog;

use Configuration;
use Cuttlefish\Controller;
use Cuttlefish\Files;
use Cuttlefish\Html;

class ControllerArchives extends ControllerPosts
{
	protected static $name = 'archive';
    /**
     * @return void
     */
    public function records()
    {
        $content_dir = parent::get_content_path(parent::$name);
        $Files         = new Files($content_dir, $this->ext);
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
            'controller' => self::$name,
            'model'      => $this->Model->name,
        ));
    }
}