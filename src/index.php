<?php

use Cuttlefish\Blog;

define('BASE_FILEPATH', rtrim(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']), '/') . '/');
define('BASE_PATH', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));

require '../vendor/autoload.php';
require '../Configuration.php';

$App = new Cuttlefish\App();
$App->run();
