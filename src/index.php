<?php

use Cuttlefish\Blog;

define('BASE_FILEPATH', rtrim(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']), '/') . '/');
define('BASE_PATH', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));

require '../vendor/autoload.php';
require 'Configuration.php';

$App = new Blog\App();
$App->run([
    // compatibility with theme
    'feeds' => Blog\ControllerFeed::class,
    'pages' => Blog\ControllerPage::class,
    'posts' => Blog\ControllerPost::class,
    'errors' => Blog\ControllerError::class,
    'images' => Blog\ControllerImage::class,
    'page' => null,
    'post' => null,
    'error' => null,
    'image' => null,
    'feed' => null,
]);
