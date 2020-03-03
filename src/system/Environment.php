<?php

namespace Cuttlefish;

use Configuration;

class Environment
{
    protected $register;

    public function __construct()
    {
        $this->addIncludePath(Filesystem::convertUrlToPath('/' . Configuration::APPLICATION_FOLDER));

        if ($this->isNewInstall()) {
            $this->createSystemFolders();
            $this->writeHtaccess();
        }

        // Externals environment
        $this->registerExternals();
        session_start();
    }

    protected function addIncludePath($path)
    {
        set_include_path(get_include_path() . PATH_SEPARATOR . realpath($path));
    }

    protected function isNewInstall()
    {
        return ! ( is_dir(Configuration::CACHE_FOLDER) && is_dir(Configuration::CONTENT_FOLDER) );
    }

    protected function createSystemFolders()
    {
        $cfg_content_folder = Configuration::CONTENT_FOLDER;

        $folders = array(
            Configuration::LOGS_FOLDER,
            Configuration::CACHE_FOLDER,
            $cfg_content_folder . '/pages',
            $cfg_content_folder . '/posts',
            $cfg_content_folder . '/errors',
            Configuration::THEMES_FOLDER,
        );
        foreach ($folders as $folder) {
            $ok[] = Filesystem::requireFolder($folder);
        }
        if (in_array(false, $ok)) {
            trigger_error('Create the missing folders, then retry.', E_USER_ERROR);
        }
    }

    public function writeHtaccess()
    {
        $directory_index = "index.html index.xml";
        $path            = Configuration::CACHE_FOLDER . DIRECTORY_SEPARATOR . ".htaccess";
        $fp              = fopen($path, 'w');
        fwrite($fp, "DirectoryIndex  $directory_index\n");
        fwrite($fp, "ErrorDocument 404 /errors/404/\n");
        fclose($fp);
    }

    protected function registerExternals()
    {
        $Files = new Files(array( 'url' => '/system/Ext' ), 'php');
        foreach ($Files->files() as $key => $filepath) {
            $this->register[ pathinfo($filepath, PATHINFO_FILENAME) ] = true;
            $this->addIncludePath(pathinfo($filepath, PATHINFO_DIRNAME));
        }
    }
}
