<?php

namespace Cuttlefish;

use Cuttlefish\Defaults;

class App
{
    public $Security;
    public $Cache;
    public $Environment;

    public function __construct()
    {
        $this->Cache = new Cache();
        if ($this->Cache->hasExistingCachefile()) {
             $bytes = readfile($this->Cache->convertUrlpathToFilepath());
            if ($bytes !== false) {
                $this->Cache->is_cached = true;
                return;
            }
        }

        // Setup environment
        $this->Environment = new Environment();
        $this->Security    = new Security();
    }

    public function run()
    {
        if ($this->Cache->is_cached) {
            return;
        }

        // Process request if not statically cached.
        $this->Cache->start();
        new Router();
        $this->Cache->end();
    }
}
