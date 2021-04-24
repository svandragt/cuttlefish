<?php

namespace Cuttlefish\Blog;

use Cuttlefish\Controller;
use Cuttlefish\Files;
use Cuttlefish\Html;

class ControllerArchive extends Controller
{
    public static string $name = 'archive';
    public static string $modelClass = ModelPost::class;
    public static string $contentPath = 'posts';

    /**
     * @return void
     */
    public function records()
    {
        $content_dir   = $this->getContentPath();
        $Files         = new Files($content_dir, $this->ext);
        $this->records = $Files->files();
    }

    /**
     * @return void
     */
    public function model()
    {
        $this->Model = new self::$modelClass($this->records);
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
