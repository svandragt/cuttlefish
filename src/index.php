<?php

use VanDragt\Carbon;

define( 'BASE_FILEPATH', rtrim(str_replace( 'index.php', '', $_SERVER['SCRIPT_FILENAME'] ),'/') . '/' );
define( 'BASE_PATH', str_replace( 'index.php', '', $_SERVER['SCRIPT_NAME'] ) );

date_default_timezone_set( 'UTC' );

$loader = require '../vendor/autoload.php';

require 'Configuration.php';

class App {
	private $security;
	private $cache;
	private $environment;

	function __construct() {
		// Prime a new cache and start caching
		$this->cache = new Carbon\Cache();
		if ( $this->cache->has_existing_cachefile() ) {
			exit( 'cache disabled' );
			// exit(readfile($Cache->cache_file_from_url()));
		}

		// Setup environment
		$this->environment = new Carbon\Environment();
		$this->security    = new Carbon\Security();
	}

	function __destruct() {
		$this->cache->start();

		// Process request
		new Carbon\Request();

		// Save cache
		$this->cache->end();
	}

	/**
	 * @return Carbon\Security
	 */
	public function getSecurity() {
		return $this->security;
	}
}

global $app;
$app = new App();
