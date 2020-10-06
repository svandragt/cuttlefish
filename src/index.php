<?php

use Cuttlefish\Blog;

define('BASE_DIR', dirname($_SERVER['SCRIPT_FILENAME']) . '/');

require '../vendor/autoload.php';
require '../Configuration.php';

$App = Cuttlefish\App::getInstance();
$App->run();
