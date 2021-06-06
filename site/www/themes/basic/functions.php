<?php

use Cuttlefish\App;
use Cuttlefish\Blog\ControllerPages;

if (! defined('BASE_DIR')) {
    exit('No direct script access allowed');
}

/**
 * Shorthand function to link to internal url
 *
 * @param  string $internal_url internal url
 *
 * @return string      index independent internal url
 */
function href($internal_url)
{
    $Url = new Cuttlefish\Url($internal_url);


    // relative links for portability.
    return $Url->url_relative;
}

/**
 * List pages in templated format
 *
 * @return string html of list of pages
 */
function pages()
{
    $output     = '';
    $Router     = App::getInstance()->Router;
    $pages_path = $Router->Controller->getContentPath(ControllerPages::class);

    $Files = new Cuttlefish\Files($pages_path, Configuration::CONTENT_EXT);
    $route = $Router->routeFromClass(ControllerPages::class);
    foreach ($Files->files() as $path) {
        $filename   = pathinfo($path, PATHINFO_FILENAME);
        $fake_title = ucwords(str_replace("-", " ", $filename));
        $output     .= sprintf("<li><a href='%s'>%s</a></li>", href("/$route/$filename"), $fake_title);
    }

    return $output;
}
