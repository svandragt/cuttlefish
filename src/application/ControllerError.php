<?php

namespace Cuttlefish\Blog;

use Configuration;
use Cuttlefish\Controller;
use Cuttlefish\Filesystem;
use Cuttlefish\Html;

class ControllerError extends Controller
{
    public static string $name = 'error';
    public static string $modelClass = ModelPage::class;
    public static string $contentPath = 'errors';

    /**
     * @return void
     */
    public function records()
    {
        $path = $this->getContentPath() . implode("/", $this->args) . '.' . $this->ext;
        $this->records = [ $path ];
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
