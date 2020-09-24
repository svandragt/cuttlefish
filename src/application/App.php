<?php

namespace Cuttlefish\Blog;

use Cuttlefish;

class App extends Cuttlefish\App
{
	/**
	 * @param array $routes Additional routes.
	 *
	 * @return void
	 */
    public function run(array $routes = [])
    {
        $default_routes = [
            'admin' => ControllerAdmin::class,
            'archive' => ControllerArchive::class,
            'errors' => ControllerError::class,
            'feed' => ControllerFeed::class,
            'home' => ControllerHome::class,
            'images' => ControllerImage::class,
            'pages' => ControllerPage::class,
            'posts' => ControllerPost::class,
        ];
        $routes = array_merge($default_routes, $routes);
        $routes = array_filter($routes);
        parent::run($routes);
    }
}
