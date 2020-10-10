<?php

namespace Cuttlefish\Blog;

use Configuration;
use Cuttlefish\Controller;
use Cuttlefish\File;

// single image
class ControllerImages extends Controller
{
	public static $name = 'image';

    /**
     * @return void
     */
    public function records()
    {
        $this->records = [$this->get_content_path() . implode('/', $this->args) ];
    }

    /**
     * @return void
     */
    public function model()
    {
        $this->Model = new ModelFile($this->records);
    }

    /**
     * @return void
     */
    public function view()
    {
        parent::view();
        $this->View = new File($this->Model->contents[0]);
        $this->View->render();
    }
}
