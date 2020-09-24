<?php

namespace Cuttlefish\Blog;

use Cuttlefish;

class App extends Cuttlefish\App
{
    /**
     * @return void
     */
    public function run(array $routes)
    {
        $default_routes = [
            'admin' => ControllerAdmin::class,
            'archive' => ControllerArchive::class,
            'error' => ControllerError::class,
            'feed' => ControllerFeed::class,
            'home' => ControllerHome::class,
            'image' => ControllerImage::class,
            'page' => ControllerPage::class,
            'post' => ControllerPost::class,
        ];
        $routes = array_merge($default_routes, $routes);
        $routes = array_filter($routes);
        parent::run($routes);
    }
}
