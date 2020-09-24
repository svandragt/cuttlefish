<?php

namespace Cuttlefish;

use Configuration;

class Controller
{
    protected $ext;
    protected $args;
    protected $records = [];
    protected $Model;
    protected $View;
    protected $content;

    public function __construct($parent, $args)
    {
        $this->content = Configuration::CONTENT_FOLDER;
        $this->ext     = Configuration::CONTENT_EXT;
        $this->args    = $args;
        $this->init();
    }

    /**
     * @return void
     */
    public function init()
    {
        $this->records();
        $this->model();
        $this->view();
    }

    /**
     * implement $this->Records in your controller
     *
     * @return void
     */
    public function records()
    {
    }

    /**
     * implement $this->Model in your controller
     *
     * @return void
     */
    public function model()
    {
    }

    /**
     * implement $this->View in your controller
     *
     * @return void
     */
    public function view()
    {
        include_once( 'helpers.php' );
    }
}
