<?php

namespace Cuttlefish;

use Configuration;
use Cuttlefish\Blog\ControllerAdmin;
use Cuttlefish\Blog\ControllerArchive;
use Cuttlefish\Blog\ControllerError;
use Cuttlefish\Blog\ControllerFeeds;
use Cuttlefish\Blog\ControllerHome;
use Cuttlefish\Blog\ControllerImages;
use Cuttlefish\Blog\ControllerPages;
use Cuttlefish\Blog\ControllerPosts;
use Dotenv\Dotenv;

class App
{
    public Security $Security;
    public Cache $Cache;
    public Environment $Environment;
    public Router $Router;

    private static $instance = null;

    protected function __construct()
    {
        $this->Cache = new Cache();
        $file_path = $this->Cache->convertUrlpathToFilepath('');
        if (Configuration::CACHE_ENABLED && is_readable($file_path)) {
            header('X-Cuttlefish-Cached: true');
            $bytes                       = readfile($file_path);
            if ($bytes !== false) {
                exit();
            }
        }

        // Setup environment
        $this->Environment = new Environment();
        $this->Security    = new Security();
    }

    public function run(array $routes = [])
    {
        // Process request if not statically cached.
        $this->Cache->start();
        $this->Router = new Router([
            'admin'   => ControllerAdmin::class,
            'archive' => ControllerArchive::class,
            'errors'  => ControllerError::class,
            'feeds'   => ControllerFeeds::class,
            'home'    => ControllerHome::class,
            'images'  => ControllerImages::class,
            'pages'   => ControllerPages::class,
            'posts'   => ControllerPosts::class,
            ...$routes,
        ]);
        $this->Router->loadController();
        $this->Cache->end();
    }


    /**
     * Singleton. The object is created from within the class itself
     * only if the class has no instance.
     *
     * @return App
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            if (is_readable(dirname(BASE_DIR) . '/.env')) {
                $dotenv = Dotenv::createImmutable(dirname(BASE_DIR));
                $dotenv->load();
            }
            self::$instance = new App();
        }

        return self::$instance;
    }
}
