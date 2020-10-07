<?php

namespace Cuttlefish;

use Configuration;
use RuntimeException;

class Cache
{
    /**
     * Current working directory
     * @var string
     */
    protected $cwd = '';

    public function __construct()
    {
        $this->cwd = getcwd(); // set current working directory
    }

    /**
     * Write page to disk if cache is enabled
     *
     * @return void
     */
    public function end(): void
    {
        // Not a bug (LOL): https://bugs.php.net/bug.php?id=30210
        chdir($this->cwd);
        if ($this->canCache()) {
            $this->writeToDisk(ob_get_flush(), '');
            exit;
        }
    }

    /**
     * Returns possibility of caching the page based on environment and configuration.
     *
     * @return boolean whether caching is possible
     */
    protected function canCache()
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
    protected function writeToDisk(string $contents, string $url_relative = '')
    {
        $path    = $this->convertUrlpathToFilepath($url_relative);
        $dirname = pathinfo($path, PATHINFO_DIRNAME);

        if (! is_dir($dirname) && ! mkdir($dirname, 0777, true) && ! is_dir($dirname)) {
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
    public function convertUrlpathToFilepath(string $path_info): string
    {

        $path_info = $this->sanitizePathinfo($path_info);

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
     *
     * @return void
     */
    public function abort(): void
    {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
    }

    /**
     * Start caching
     *
     * @return void
     */
    public function start(): void
    {
        ob_start();
    }

    /**
     * Generate a static version of the complete site
     *
     * @return string list of output messages detailing the generated files
     */
    public function generateSite(): string
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
        $Files   = new Files($content, $ext);

        $cache_urls = array();

        foreach ($Files->files() as $index => $file_path) {
            $File         = new File($file_path);
            $cache_urls[] = Url::fromFile($File);
        }

        $urls = array(
            '/',
            '/feeds/post',
            '/archive',
        );
        foreach ($urls as $path) {
            $cache_urls[] = new Url($path);
        }

        foreach ($cache_urls as $Url) {
            $contents = $Curl->getURLContents($Url->url_absolute);

            if (empty($contents)) {
                throw new RuntimeException("ERROR: no contents for {$Url->url_absolute}");
            }

            if (Configuration::CACHE_ENABLED === false) {
                $path   = $this->writeToDisk($contents, $Url->url_relative);
                $output .= "Written: $path<br>" . PHP_EOL;
            }
        }
        $Curl->close();

        $output .= $this->copyThemeFiles(array( 'css', 'js', 'png', 'gif', 'jpg' ));

        return $output;
    }

    /**
     * Completely clear the site cache
     *
     * @return string list of output messages detailing the removed cachefiles
     */
    public function clear()
    {
        $dir    = $this->getCacheFolder();
        $output = sprintf('Removing  all files in %s<br>', $dir);
        $Files  = new Files($dir);
        $output .= $Files->removeAll();
        $dirs   = Filesystem::subdirs(realpath($dir . '/.'), false);
        foreach ($dirs as $dir) {
            Filesystem::removeDirs(realpath($dir . '/.'));
        }
        App::getInstance()->Environment->writeHtaccess();

        return (string) $output;
    }

    /**
     * @return false|null|string
     */
    protected function getCacheFolder()
    {
        return realpath(BASE_DIR . str_replace("/", DIRECTORY_SEPARATOR, Configuration::CACHE_FOLDER));
    }

    /**
     * Copying of the theme files to the static site output folder
     *
     * @param  array $file_types list of filetypes to process
     *
     * @return string             messages detailing the process
     */
    protected function copyThemeFiles($file_types)
    {

        include_once('helpers.php');
        $output    = 'Copying files from theme: <br><br>';

        foreach ($file_types as $file_type) {
            $output .= "filetype: $file_type<br>";
            $Files  = new Files(BASE_DIR . theme_path(), $file_type);

            $destination_files = array();
            foreach ($Files->files() as $key => $source) {
                $output              .= " - $key: $source<br>";
                $cache               = ltrim(Configuration::CACHE_FOLDER, "./");
                $destination_files[] = str_replace('src', $cache, $source);
            }
            Filesystem::copyFiles($Files->files(), $destination_files);
        }

        return $output;
    }

    /**
     * @param $path_info
     *
     * @return string
     */
    protected function sanitizePathinfo(string $path_info)
    {
        if (isset($_SERVER['PATH_INFO']) && empty($path_info)) {
            $path_info = substr($_SERVER['PATH_INFO'], 1);
        }
        $new_path_info = ltrim($path_info, '/');

        return (string) $new_path_info;
    }
}
