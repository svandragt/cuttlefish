<?php

namespace Cuttlefish;

use Configuration;

class Controller {
	protected string $ext;
	protected array $args;
	public static string $name;
	public static string $contentPath;
	protected array $records = [];
	protected Model $Model;
	protected Html $View;

	public function __construct( $args = [] ) {
		$this->ext  = Configuration::CONTENT_EXT;
		$this->args = $args;
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

    public function getContentPath($controllerClass = null): string
    {
        if (is_null($controllerClass)) {
            $controllerClass = get_class($this);
        }

        $route = $controllerClass::$contentPath;
        return Configuration::CONTENT_FOLDER . '/' . $route . '/';
    }
}
