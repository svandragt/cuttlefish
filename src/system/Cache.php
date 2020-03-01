<?php

namespace Cuttlefish;

use Configuration;
use RuntimeException;

if (! defined('BASE_FILEPATH')) {
    exit('No direct script access allowed');
}

class Cache
{
    /**
     * Current working directory
     * @var string
     */
    protected $cwd = '';

    /**
     * Is the request already cached?
     * @var boolean
     */
    public $is_cached = false;

    public function __construct()
    {
        $this->cwd = getcwd(); // set current working directory
    }

    /**
     * Write page to disk if cache is enabled
     */
    public function end()
    {
        // Not a bug (LOL): https://bugs.php.net/bug.php?id=30210
        chdir($this->cwd);
        if ($this->can_cache()) {
            $this->write_to_disk(ob_get_flush(), null);
            exit;
        }
    }

    /**
     * Returns possibility of caching the page based on environment and configuration.
     *
     * @return boolean whether caching is possible
     */
    public function can_cache()
    {
        $cache_enabled = Configuration::CACHE_ENABLED;
        if ($cache_enabled === false) {
            return false;
        }
        $is_caching = ob_get_level() > 0;
        if ($is_caching === false) {
            return false;
        }

        return error_get_last() === null;
    }

    /**
     * Writes the collected cache to disk
     *
     * @param  string $contents contents of the cache
     *
     * @param null|string $url_relative Relative URL
     *
     * @return string           path to the cache file
     */
    public function write_to_disk($contents, $url_relative = '')
    {
        $path    = $this->convert_urlpath_to_filepath($url_relative);
        $dirname = pathinfo($path, PATHINFO_DIRNAME);

        if (! is_dir($dirname) && ! mkdir($dirname, 0777, true)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $dirname));
        }
        $fp = fopen($path, 'wb');
        fwrite($fp, $contents);
        fclose($fp);

        return $path;
    }

    /**
     * Returns path to cache file based on url path.
     *
     * @param  string $path_info path to current request
     *
     * @return string            path to cache file
     */
    public function convert_urlpath_to_filepath($path_info = '')
    {

        $path_info = $this->sanitize_pathinfo($path_info);

        $file_path = pathinfo($path_info, PATHINFO_DIRNAME) . '/' . pathinfo($path_info, PATHINFO_FILENAME);
        $file_path = ltrim($file_path, '.');

        $ext = pathinfo($path_info, PATHINFO_EXTENSION);
        if (strrpos($path_info, '.') === false) {
            // Convert html request into a folder
            $file_path = rtrim($file_path, '/') . '/index';
            $ext       = 'html';

            // FIXME: If filename has the word feed in it it's xml (lol)
            if (! strrpos($file_path, 'feed/') === false) {
                $ext = 'xml';
            }
        }

        $cache_file = sprintf('%s/%s.%s', Configuration::CACHE_FOLDER, ltrim($file_path, '/'), $ext);
        $cache_file = str_replace('/', DIRECTORY_SEPARATOR, $cache_file);

        return (string) $cache_file;
    }

    /**
     * Abort caching
     */
    function abort()
    {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
    }

    /**
     * Start caching
     */
    function start()
    {
        ob_start();
    }

    /**
     * Retiurns whether page is already cached
     *
     * @return boolean page has existing cachefile
     */
    public function has_existing_cachefile()
    {
        $wants_caching = Configuration::CACHE_ENABLED;
        if (! $wants_caching) {
            return false;
        }
        $cache_file = $this->convert_urlpath_to_filepath();

        return file_exists($cache_file);
    }

    /**
     * Generate a static version of the complete site
     *
     * @return string list of output messages detailing the generated files
     */
    function generate_site()
    {
        $output = '';

        if (Configuration::INDEX_PAGE !== '') {
            die('Currently, generating a site requires enabling Pretty Urls (see readme.md for instructions).');
        }
        $output .= $this->clear();

        $output  .= "<br>Generating site:<br>" . PHP_EOL;
        $content = Configuration::CONTENT_FOLDER;
        $ext     = Configuration::CONTENT_EXT;
        $Curl    = new Curl();
        $Files   = new Files(array( 'path' => Filesystem::url_to_path("/$content"), $ext ));

        $cache_urls = array();

        foreach ($Files->files() as $index => $file_path) {
            $File         = new File($file_path);
            $Url          = new Url();
            $cache_urls[] = $Url->file_to_url($File);
        }

        $urls = array(
            '/',
            '/feeds/posts',
            '/archive',
        );
        foreach ($urls as $path) {
            $cache_urls[] = new Url($path);
        }

        foreach ($cache_urls as $Url) {
            $contents = $Curl->url_contents($Url->url_absolute);

            if (empty($contents)) {
                die("ERROR: no contents for {$Url->url_absolute}");
            }

            if (Configuration::CACHE_ENABLED === false) {
                $path   = $this->write_to_disk($contents, $Url->url_relative);
                $output .= "Written: $path<br>" . PHP_EOL;
            }
        }
        $Curl->close();

        $output .= $this->copy_themefiles(array( 'css', 'js', 'png', 'gif', 'jpg' ));

        return $output;
    }

    /**
     * Completely clear the site cache
     *
     * @return string list of output messages detailing the removed cachefiles
     */
    function clear()
    {
        global $App;
        $dir    = $this->cache_folder();
        $output = sprintf('Removing  all files in %s<br>', $dir);
        $Files  = new Files(array( 'path' => $dir ));
        $output .= $Files->remove_all();
        $dirs   = Filesystem::subdirs(realpath($dir . '/.'), false);
        foreach ($dirs as $dir) {
            Filesystem::remove_dirs(realpath($dir . '/.'));
        }
        $App->Environment->server_setup();

        return (string) $output;
    }

    function cache_folder()
    {
        return realpath(BASE_FILEPATH . str_replace("/", DIRECTORY_SEPARATOR, Configuration::CACHE_FOLDER));
    }

    /**
     * Copying of the theme files to the static site output folder
     *
     * @param  array $file_types list of filetypes to process
     *
     * @return string             messages detailing the process
     */
    public function copy_themefiles($file_types)
    {
        include_once('view_functions.php');

        $theme_dir = rtrim(theme_dir(), '/');
        $output    = 'Copying files from theme: <br><br>';

        foreach ($file_types as $file_type) {
            $output .= "filetype: $file_type<br>";
            $Files  = new Files(array( 'path' => Filesystem::url_to_path("$theme_dir") ), $file_type);

            $destination_files = array();
            foreach ($Files->files() as $key => $source) {
                $output              .= " - $key: $source<br>";
                $cache               = ltrim(Configuration::CACHE_FOLDER, "./");
                $destination_files[] = str_replace('src', $cache, $source);
            }
            Filesystem::copy_files($Files->files(), $destination_files);
        }

        return $output;
    }

    /**
     * @param $path_info
     *
     * @return string
     */
    protected function sanitize_pathinfo($path_info)
    {
        if (isset($_SERVER['PATH_INFO']) && empty($path_info)) {
            $path_info = substr($_SERVER['PATH_INFO'], 1);
        }
        $path_info = ltrim($path_info, '/');

        return (string) $path_info;
    }
}
