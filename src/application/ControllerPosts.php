<?php

namespace Cuttlefish\Blog;

use Cuttlefish\Controller;
use Cuttlefish\Html;

// single post
class ControllerPosts extends Controller
{
    public static string $name = 'post';
    public static string $contentPath = 'posts';

    /**
     * @return void
     */
    public function records()
    {
        $path          = $this->getContentPath() . implode('/', $this->args) . '.' . $this->ext;
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
            'controller' => self::$name,
            'model'      => $this->Model->name,
        ));
    }
}
