<?php

namespace Cuttlefish\Blog;

use Cuttlefish\Controller;
use Cuttlefish\File;

// single image
class ControllerImages extends Controller
{
    public static string $name = 'image';
    public static string $contentPath = 'images';

    /**
     * @return void
     */
    public function records()
    {
        $this->records = [ $this->getContentPath() . implode('/', $this->args) ];
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
