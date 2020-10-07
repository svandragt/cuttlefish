<?php

namespace Cuttlefish;

use Configuration;
use Dotenv\Dotenv;

class App
{
    public $Security;
    public $Cache;
    public $Environment;

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

    public function run()
    {
        // Process request if not statically cached.
        $this->Cache->start();
        new Router();
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
        if (self::$instance == null) {
            $dotenv = Dotenv::createImmutable(dirname(BASE_DIR));
            $dotenv->load();
            self::$instance = new App();
        }

        return self::$instance;
    }
}
