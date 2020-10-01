<?php

namespace Cuttlefish;

use Configuration;

class Environment
{
    protected $register;

    public function __construct()
    {
        if ($this->isNewInstall()) {
            $this->createSystemFolders();
            $this->writeHtaccess();
        }

        // Externals environment
        $this->registerPlugins();
        session_start();
    }

    protected function addIncludePath(string $path): void
    {
        set_include_path(get_include_path() . PATH_SEPARATOR . realpath($path));
    }

    protected function isNewInstall(): bool
    {
        return ! ( is_dir(Configuration::CACHE_FOLDER) && is_dir(Configuration::CONTENT_FOLDER) );
    }

    protected function createSystemFolders(): void
    {
        $folders = array(
            Configuration::LOGS_FOLDER,
            Configuration::CACHE_FOLDER,
            Configuration::CONTENT_FOLDER
        );

        foreach ($folders as $folder) {
            Filesystem::requireFolder($folder);
        }
    }

    public function writeHtaccess(): void
    {
        $directory_index = "index.html index.xml";
        $path            = Configuration::CACHE_FOLDER . DIRECTORY_SEPARATOR . ".htaccess";
        $fp              = fopen($path, 'w');
        fwrite($fp, "DirectoryIndex  $directory_index\n");
        fwrite($fp, "ErrorDocument 404 /errors/404/\n");
        fclose($fp);
    }

    protected function registerPlugins(): void
    {
        $Files = new Files('/plugins', 'php');
        foreach ($Files->files() as $key => $filepath) {
            $this->register[ pathinfo($filepath, PATHINFO_FILENAME) ] = true;
            $this->addIncludePath(pathinfo($filepath, PATHINFO_DIRNAME));
        }
    }
}
