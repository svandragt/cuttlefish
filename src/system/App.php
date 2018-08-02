<?php

namespace VanDragt\Carbon;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class App {
	private $security;
	private $cache;
	private $environment;

	function __construct() {
		// Prime a new cache and start caching
		$this->cache = new Cache();
		if ( $this->cache->has_existing_cachefile() ) {
			exit( 'cache disabled' );
			// exit(readfile($Cache->cache_file_from_url()));
		}

		// Setup environment
		$this->environment = new Environment();
		$this->security    = new Security();
	}

	function __destruct() {
		$this->cache->start();

		// Process request
		new Request();

		// Save cache
		$this->cache->end();
	}
}
