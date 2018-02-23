<?php


use VanDragt\Carbon;


define('BASE_FILEPATH', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . '/');
define('BASE_PATH', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));

date_default_timezone_set('UTC');

$loader = require '../vendor/autoload.php';

require './Configuration.php';

// Prime a new cache and start caching
$Cache = new Carbon\Cache();
if ($Cache->has_existing_cachefile()) {
    exit(readfile($Cache->cache_file_from_url()));
}
$Cache->start();

// Setup environment
$Environment = new Carbon\Environment();
$Security = new Carbon\Security();

// Process request
$Request = new Carbon\Request();

// Save cache
$Cache->end();
