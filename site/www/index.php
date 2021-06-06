<?php

define('BASE_DIR', dirname($_SERVER['SCRIPT_FILENAME']) . '/');

require_once 'vendor/autoload.php';
require_once 'Configuration.php';

$App = Cuttlefish\App::getInstance();
$App->run();
