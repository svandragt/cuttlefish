<?php

namespace Cuttlefish;

use Configuration;

class Environment
{
    protected $register;

    public function __construct()
    {


        $this->add_include_path(Filesystem::url_to_path('/' . Configuration::APPLICATION_FOLDER));

        if ($this->new_install()) {
            $this->new_install_setup();
        }

        // Externals environment
        $this->register_externals();
        session_start();
    }

    function add_include_path($path)
    {

        set_include_path(get_include_path() . PATH_SEPARATOR . realpath($path));
    }

    protected function new_install()
    {
        return ! ( is_dir(Configuration::CACHE_FOLDER) && is_dir(Configuration::CONTENT_FOLDER) );
    }

    protected function new_install_setup()
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
            $ok[] = Filesystem::ensure_folder_exists($folder);
        }
        if (in_array(false, $ok)) {
            trigger_error('Create the missing folders, then retry.', E_USER_ERROR);
        }
        $this->server_setup();
    }

    public function server_setup()
    {

        $directory_index = "index.html index.xml";
        $path            = Configuration::CACHE_FOLDER . DIRECTORY_SEPARATOR . ".htaccess";
        $fp              = fopen($path, 'w');
        fwrite($fp, "DirectoryIndex  $directory_index\n");
        fwrite($fp, "ErrorDocument 404 /errors/404/\n");
        fclose($fp);
    }

    protected function register_externals()
    {
        $Files = new Files(array( 'url' => '/system/Ext' ), 'php');
        foreach ($Files->files() as $key => $filepath) {
            $this->register[ pathinfo($filepath, PATHINFO_FILENAME) ] = true;
            $this->add_include_path(pathinfo($filepath, PATHINFO_DIRNAME));
        }
    }
}
