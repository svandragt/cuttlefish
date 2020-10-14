<?php

namespace Cuttlefish\Blog;

use Configuration;
use Cuttlefish\Controller;
use Cuttlefish\Html;

// single page
class ControllerPages extends Controller
{
	public static string $name = 'page';
    /**
     * @return void
     */
    public function records()
    {
        $path = $this->get_content_path(self::class) . implode('/', $this->args) . '.' . $this->ext;
        $this->records = [ $path ];
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

        $this->View = new Html($this->Model->contents, array(
            'layout'     => 'layout.php',
            'controller' => self::$name,
            'model'      => $this->Model->name,
        ));
    }
}
