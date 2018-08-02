<?php

define( 'BASE_FILEPATH', rtrim( str_replace( 'index.php', '', $_SERVER['SCRIPT_FILENAME'] ), '/' ) . '/' );
define( 'BASE_PATH', str_replace( 'index.php', '', $_SERVER['SCRIPT_NAME'] ) );

date_default_timezone_set( 'UTC' );

$loader = require '../vendor/autoload.php';

require 'Configuration.php';

global $app;
$app = new VanDragt\Carbon\App();
