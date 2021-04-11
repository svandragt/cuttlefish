<?php

namespace Cuttlefish;

use Configuration;

class Controller
{
    protected $ext;
    protected $args;

	public static string $name;
	protected array $records = [];
    protected Model $Model;
    protected Html $View;

    public function __construct($args = [])
    {
        $this->ext     = Configuration::CONTENT_EXT;
        $this->args    = $args;
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

    public function get_content_path(): string {
    	// TODO should be based on model not controller
        $class = get_class( $this );
	    $route = App::getInstance()->Router->routeFromClass( $class );
     	return Configuration::CONTENT_FOLDER . '/' . $route . '/';
    }
}
