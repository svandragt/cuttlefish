<?php

namespace Cuttlefish;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class App {
	public $Security;
	public $Cache;
	public $Environment;

	public function __construct() {
		$this->Cache = new Cache();
		if ( $this->Cache->has_existing_cachefile() ) {
			 $bytes = readfile( $this->Cache->convert_urlpath_to_filepath() );
			 if ( $bytes !== false) {
			 	$this->Cache->is_cached = true;
			 	return;
			 }
		}

		// Setup environment
		$this->Environment = new Environment();
		$this->Security    = new Security();
	}

	public function __destruct() {
		if ( $this->Cache->is_cached ) {
			return;
		}

		// Process request if not statically cached.
		$this->Cache->start();
		new Request();
		$this->Cache->end();
	}
}
