<?php

use Cuttlefish\Blog;

define('BASE_DIR', dirname($_SERVER['SCRIPT_FILENAME']) . '/');

require_once 'vendor/autoload.php';
require_once 'Configuration.php';

$App = Cuttlefish\App::getInstance();
$App->registerRouteControllers([
    'archive' => Blog\ControllerArchive::class,
    'errors' => Blog\ControllerError::class,
    'feeds' => Blog\ControllerFeeds::class,
    'home' => Blog\ControllerHome::class,
    'images' => Blog\ControllerImages::class,
    'pages' => Blog\ControllerPages::class,
    'posts' => Blog\ControllerPosts::class,
]);
$App->run();
