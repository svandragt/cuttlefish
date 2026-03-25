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
            $this->writeToDisk(ob_get_flush());
            exit;
        }
    }

    /**
     * Returns possibility of caching the page based on environment and configuration.
     *
     * @return boolean whether caching is possible
     */
    protected function canCache(): bool
    {
        if (Configuration::CACHE_ENABLED === false) {
            return false;
        }
        if (ob_get_level() === 0) {
            return false;
        }

        return error_get_last() === null;
    }

    /**
     * Writes the collected cache to disk
     *
     * @param string $contents contents of the cache
     *
     * @param string $urlRelative Relative URL
     *
     * @return string           path to the cache file
     */
    protected function writeToDisk(string $contents, string $urlRelative = ''): string
    {
        $path = $this->convertUrlpathToFilepath($urlRelative);
        $dirname = pathinfo($path, PATHINFO_DIRNAME);

        if (!is_dir($dirname) && !mkdir($dirname, 0777, true) && !is_dir($dirname)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $dirname));
        }
        $pointer = fopen($path, 'wb');
        fwrite($pointer, $contents);
        fclose($pointer);
        return $path;
    }

    /**
     * Returns path to cache file based on url path.
     *
     * @param string $pathInfo path to current request
     *
     * @return string            path to cache file
     */
    public function convertUrlpathToFilepath(string $pathInfo): string
    {
        $pathInfo = $this->sanitizePathinfo($pathInfo);

        $filePath = pathinfo($pathInfo, PATHINFO_DIRNAME) . '/' . pathinfo($pathInfo, PATHINFO_FILENAME);
        $filePath = ltrim($filePath, '.');

        $ext = pathinfo($pathInfo, PATHINFO_EXTENSION);
        if (strrpos($pathInfo, '.') === false) {
            // Convert html request into a folder
            $filePath = rtrim($filePath, '/') . '/index';
            $ext = 'html';

            // FIXME: If filename has the word feed in it it's xml (lol)
            if (!strrpos($filePath, 'feed/') === false) {
                $ext = 'xml';
            }
        }

        $cacheFile = sprintf('%s/%s.%s', Configuration::CACHE_FOLDER, ltrim($filePath, '/'), $ext);
        $cacheFile = str_replace('/', DIRECTORY_SEPARATOR, $cacheFile);

        return (string)$cacheFile;
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
        // TODO: only clear existing cache when forced.
        $output .= $this->clear();

        $output .= "<br>Generating site:<br>" . PHP_EOL;
        $content = Configuration::CONTENT_FOLDER;
        $ext = Configuration::CONTENT_EXT;
        $curl = new Curl();
        $files = new Files($content, $ext);

        $cacheUrls = array();

        foreach (array_values($files->files()) as $filePath) {
            $file = new File($filePath);
            $cacheUrls[] = Url::fromFile($file);
        }

        $urls = array(
            '/',
            '/feeds/post',
            '/archive',
        );
        foreach ($urls as $path) {
            $cacheUrls[] = new Url($path);
        }

        foreach ($cacheUrls as $url) {
            $contents = $curl->getURLContents($url->urlAbsolute);

            if (empty($contents)) {
                $urlAbsolute = $url->urlAbsolute;
                throw new RuntimeException("ERROR: no contents for $urlAbsolute");
            }

            if (Configuration::CACHE_ENABLED === false) {
                $path = $this->writeToDisk($contents, $url->url_relative);
                $output .= "Written: $path<br>" . PHP_EOL;
            }
        }
        $curl->close();

        $output .= $this->copyThemeFiles(array( 'css', 'js', 'png', 'gif', 'jpg' ));

        return $output;
    }

    /**
     * Completely clear the site cache
     *
     * @return string list of output messages detailing the removed cachefiles
     */
    public function clear(): string
    {
        $dir = $this->getCacheFolder();
        $output = sprintf('Removing  all files in %s<br>', $dir);
        $files = new Files($dir);
        $output .= $files->removeAll();
        $dirs = Filesystem::subdirs(realpath($dir . '/.'));
        foreach ($dirs as $dir) {
            Filesystem::removeDirs(realpath($dir . '/.'));
        }
        App::getInstance()->Environment->writeHtaccess();

        return $output;
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
     * @param array $fileTypes list of filetypes to process
     *
     * @return string             messages detailing the process
     */
    protected function copyThemeFiles(array $fileTypes): string
    {
        include_once('helpers.php');
        $output = 'Copying files from theme: <br><br>';


        foreach ($fileTypes as $fileType) {
            $output .= "filetype: $fileType<br>";
            $files = new Files(BASE_DIR . theme_path(), $fileType);

            $destinationFiles = array();
            foreach ($files->files() as $key => $source) {
                $output .= " - $key: $source<br>";
                $cache = ltrim(Configuration::CACHE_FOLDER, "./");
                $destinationFiles[] = str_replace('src', $cache, $source);
            }
            Filesystem::copyFiles($files->files(), $destinationFiles);
        }

        return $output;
    }

    /**
     * @param string $pathInfo
     *
     * @return string
     */
    protected function sanitizePathinfo(string $pathInfo): string
    {
        if (isset($_SERVER['PATH_INFO']) && empty($pathInfo)) {
            $pathInfo = substr($_SERVER['PATH_INFO'], 1);
        }

        return ltrim($pathInfo, '/');
    }
}
