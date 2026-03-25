<?php

namespace Cuttlefish;

use Configuration;
use Dotenv\Dotenv;

class App
{
    public Cache $Cache;
    public Environment $Environment;
    public Router $Router;

    private static ?App $instance = null;
    private array $routeControllers = [];

    /**
     * @param array $routes
     */
    public function registerRouteControllers(array $routes): void
    {
        $this->routeControllers = array_merge($this->routeControllers, $routes);
    }

    protected function __construct()
    {
        $this->Cache = new Cache();
        $filePath = $this->Cache->convertUrlpathToFilepath('');
        if (Configuration::CACHE_ENABLED && is_readable($filePath)) {
            header('X-Cuttlefish-Cached: true');
            $bytes = readfile($filePath);
            if ($bytes !== false) {
                exit(0);
            }
        }

        // Setup environment
        $this->Environment = new Environment();
    }

    public function run(): void
    {
        // Process request if not statically cached.
        $this->Cache->start();
        $this->Router = new Router($this->routeControllers);
        $this->Router->loadController();
        $this->Cache->end();
    }


    /**
     * Singleton. The object is created from within the class itself
     * only if the class has no instance.
     *
     * @return App
     */
    public static function getInstance(): ?App
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
