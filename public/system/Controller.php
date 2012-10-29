<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Controller extends Extension {

	function __construct($parent, $args) {
		parent::__construct($parent, $args);

		$this->content     = Configuration::CONTENT_FOLDER;
		$this->controller  = get_class($this);
		$this->ext         = Configuration::CONTENT_EXT;
		$this->layout      = 'layout.php';
		$this->model       = 'page';
		$this->view        = 'Html';
		$this->content_dir = strtolower(sprintf("/%s/%ss",$this->content, $this->model));
		$this->args = $args;
		Log::debug(__FUNCTION__ . " called.");
	}

	function class_not_callable($named_class) {
		die("class $named_class not callable.");
	}

	public function init() {
		parent::init();
 		$this->load_records();
 		$this->load_model();
 		$this->load_view();
	}

	public function load_records() {
 		$this->Records = new Files($this->content_dir, $this->ext);
	}

	public function load_model() {
		$model_class = 'Model' . $this->model;

		if ( class_exists ( $model_class, true )) {
			$this->_parent->model = new $model_class( $this );
			$this->_parent->model->init();
		} else $this->class_not_callable($model_class);
	}

	public function load_view() {
		include ('view_functions.php');
		include ('functions.php');
		$view_class = $this->view;

		if ( class_exists ( $view_class, true )) {
			$this->_parent->view = new $view_class( $this->_parent->model->contents, array(
				'layout'     => $this->layout,
				'controller' => $this->controller,
				'model'      => $this->model,
			) ) ;
		} else $this->class_not_callable($view_class);
	}
}
	