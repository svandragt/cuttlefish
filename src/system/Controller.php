<?php

namespace Cuttlefish;

use Configuration;

class Controller
{
    protected $ext;
    protected $args;
	protected static $name;
	protected $records = [];
    protected $Model;
    protected $View;

    public function __construct($parent, $args)
    {
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
        include_once('helpers.php');
    }

    public static function get_content_path($name = '') {
    	if (empty($name)) {
    		$name = self::$name;
	    }
    	return Configuration::CONTENT_FOLDER . '/' . $name . 's/';
    }
}
