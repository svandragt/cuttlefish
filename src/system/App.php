<?php

namespace Mana;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class App {
	public $Security;
	public $Cache;
	public $Environment;

	public function __construct() {
		// Prime a new cache and start caching
		$this->Cache = new Cache();
		if ( $this->Cache->has_existing_cachefile() ) {
			exit( 'cache disabled' );
			// exit(readfile($Cache->cache_file_from_url()));
		}

		// Setup environment
		$this->Environment = new Environment();
		$this->Security    = new Security();
	}

	public function __destruct() {
		$this->Cache->start();
		new Request();
		$this->Cache->end();
	}
}
