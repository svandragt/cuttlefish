<?php

use VanDragt\Carbon;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class ControllerAdmin extends Carbon\Controller {
	protected $contents;
	// admin section does not use content files

	public $allowed_methods = array(
		'index'       => 'Overview',
		'draft'       => 'New post template',
		'clear_cache' => 'Clear cache',
		'generate'    => 'Generate static site',
		'logout'      => 'Logout',
	);

	function init() {
		global $Cache;
		$Cache->abort();

		$action = ( isset( $this->args[0] ) ) ? $this->args[0] : 'index';
		if ( $this->is_allowed_method( $action ) ) {
			$this->contents = $this->$action();
		} else {
			$this->is_allowed_method_fail( $action );
		}

		parent::init();
	}

	function is_allowed_method( $action ) {
		return array_key_exists( $action, $this->allowed_methods );
	}

	/* admin functionality */

	function is_allowed_method_fail( $action ) {
		exit( "method $action not allowed" );
	}

	function view() {
		parent::view();

		$this->view = new Carbon\Html( $this->contents, array(
			'layout'     => 'single.php',
			'controller' => 'admin',
			'model'      => 'page',
		) );
	}

	function index() {
		global $Security;
		if ( $Security->is_loggedin() ) {
			return $this->show_tasks();
		} else {
			return $this->show_login();
		}
	}

	function show_tasks() {
		$output = '<ul>';
		$am     = $this->allowed_methods;
		array_shift( $am );
		foreach ( $am as $key => $value ):
			$url    = new Carbon\Url();
			$output .= sprintf( '<li><a href="%s">%s</a></li>', $url->index( "/admin/$key" )->url, $value );
		endforeach;

		$output .= '</ul>';

		return $output;
	}

	function show_login() {
		global $Security;

		return $Security->login();
	}

	function draft() {
		global $Security;
		$Security->login_redirect();
		// Broken draft but Request object shouldn't be called from here.
		// global $Request;
		// $Request->template_download('post');
	}

	function clear_cache() {
		global $Security;
		global $Cache;
		$Security->login_redirect();

		return $Cache->clear();
	}

	function generate() {
		global $Security;
		global $Cache;

		$Security->login_redirect();
		echo $Cache->generate_site();
	}

	function logout() {
		global $Security;

		$Security->login_redirect();

		return $Security->logout();
	}
}