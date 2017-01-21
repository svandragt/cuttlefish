<?php
namespace VanDragt\Carbon\Sys;

if (!defined('BASE_FILEPATH')) {
    exit('No direct script access allowed');
}

class Cache extends Extension
{

    protected $cwd;

    public function __construct($parent)
    {
        parent::__construct($parent);
        $this->cwd = getcwd(); // set current working directory
    }

    /**
     * Write page to disk if cache is enabled
     */
    public function end()
    {
        chdir($this->cwd); // Not a bug (LOL): https://bugs.php.net/bug.php?id=30210
        if ($this->has_cacheable_page_request()) {
            $this->write_cache_to_disk(NULL, ob_get_contents());
            ob_end_flush();
        }
    }

    /**
     * Returns possibility of caching the page based on environment and configuration
     *
     * @return boolean whether caching is possible
     */
    function has_cacheable_page_request()
    {
        $cache_enabled = \Configuration::CACHE_ENABLED;
        $is_caching = !ob_get_level() == 0;
        $has_noerrors = is_null(error_get_last());
        $has_cacheable_page_request = ($cache_enabled && $is_caching && $has_noerrors);

        return (boolean)$has_cacheable_page_request;
    }

    /**
     * Writes the collected cache to disk
     *
     * @param  object $url_obj url object to be written
     * @param  string $contents contents of the cache
     *
     * @return string           path to the cache file
     */
    function write_cache_to_disk($url_obj, $contents)
    {
        $url = (is_object($url_obj)) ? $url_obj->url : $url_obj;
        $path = $this->cache_file_from_url($url);
        $dirname = pathinfo($path, PATHINFO_DIRNAME);

        if (!is_dir($dirname)) {
            mkdir($dirname, 0777, TRUE);
        }
        $fp = fopen($path, 'w');
        fwrite($fp, $contents);
        fclose($fp);

        return $path;
    }

    /**
     * Returns path to cache file based on url path
     *
     * @param  string $path_info path to current request
     *
     * @return string            path to cache file
     */
    function cache_file_from_url($path_info = NULL)
    {
        $ds = DIRECTORY_SEPARATOR;
        if (is_null($path_info)) {
            $path_info = substr($_SERVER['PATH_INFO'], 1);
        }
        $path_info = ltrim($path_info, '/');
        $filename = pathinfo($path_info, PATHINFO_DIRNAME) . '/' . pathinfo($path_info, PATHINFO_FILENAME);
        $filename = ltrim($filename, '.');

        $ext = pathinfo($path_info, PATHINFO_EXTENSION);
        if (strrpos($path_info, '.') === FALSE) {
            $filename = rtrim($filename, '/') . '/index';
            $ext = 'html';

            if (!strrpos($filename, 'feed') === FALSE) {
                $ext = 'xml';
            }
        }
        $cache_file = sprintf("%s/%s.%s", \Configuration::CACHE_FOLDER, ltrim($filename, '/'), $ext);
        $cache_file = str_replace('/', $ds, $cache_file);

        return (string)$cache_file;
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
    function has_existing_cachefile()
    {
        $cache_file = $this->cache_file_from_url();
        $has_cache_file = file_exists($cache_file);
        $has_caching_enabled = \Configuration::CACHE_ENABLED;

        return ($has_cache_file && $has_caching_enabled);
    }

    /**
     * Generate a static version of the complete site
     *
     * @return string list of output messages detailing the generated files
     */
    function generate_site()
    {
        $output = '';

        if (\Configuration::INDEX_PAGE !== '') {
            die('Currently, generating a site requires enabling Pretty Urls (see readme.md for instructions).');
        }
        $output .= $this->clear();

        $output .= "<br>Generating site:<br>" . PHP_EOL;
        $content = \Configuration::CONTENT_FOLDER;
        $ext = \Configuration::CONTENT_EXT;
        $c = new Curl;
        $fs = new Files(array('path' => Filesystem::url_to_path("/$content"), $ext));

        $cache_urls = array();

        foreach ($fs->getCollection() as $index => $file_path) {
            $file_obj = new File($file_path);
            $url_obj = new Url();
            $cache_urls[] = $url_obj->file_to_url($file_obj)->index();
        }

        $urls = array(
            '/',
            '/feeds/posts',
            '/archive',
        );
        foreach ($urls as $key => $value) {
            $url = new Url();
            $cache_urls[] = $url->index($value);
        }

        foreach ($cache_urls as $url) {
            $url2 = clone $url;
            $url_string = $url2->abs()->url;

            // support Vagrant port forwarding where local HTTP_HOST is different from developer
            if (defined('Configuration::SERVER_HTTP_HOST')) {
                $url_string = str_replace($_SERVER['HTTP_HOST'], \Configuration::SERVER_HTTP_HOST, $url_string);
            }
            $contents = $c->url_contents($url_string);

            if (empty($contents)) {
                die("ERROR: no contents for {$url2->abs()->url}");
            }

            if (\Configuration::CACHE_ENABLED == FALSE) {
                $path = $this->write_cache_to_disk($url, $contents);
                $output .= "Written: $path<br>" . PHP_EOL;
            }
        }
        $c->close();

        $output .= $this->copy_themefiles(array('css', 'js', 'png', 'gif', 'jpg'));

        return (string)$output;
    }

    /**
     * Completely clear the site cache
     *
     * @return string list of output messages detailing the removed cachefiles
     */
    function clear()
    {
        $dir = $this->cache_folder();
        $output = sprintf("Removing  all files in %s<br>", $dir);
        $files = new Files(array('path' => $dir));
        $output .= $files->remove_all();
        $dirs = Filesystem::subdirs(realpath($dir . '/.'), FALSE);
        foreach ($dirs as $dir) {
            Filesystem::remove_dirs(realpath($dir . '/.'));
        }
        $this->_parent->Environment->server_setup();

        return (string)$output;
    }

    function cache_folder()
    {
        return realpath(BASE_FILEPATH . str_replace("/", DIRECTORY_SEPARATOR, \Configuration::CACHE_FOLDER));
    }

    /**
     * Copying of the theme files to the static site output folder
     *
     * @param  array $file_types list of filetypes to process
     *
     * @return string             messages detailing the process
     */
    function copy_themefiles($file_types)
    {
        include('view_functions.php');

        // $files  = array();
        $theme_dir = rtrim(theme_dir(), '/');
        $output = "Copying files from theme: <br><br>";

        foreach ($file_types as $file_type) {
            $output .= "filetype: $file_type<br>";
            $fs = new Files(array('path' => Filesystem::url_to_path("$theme_dir")), $file_type);

            $destination_files = array();
            foreach ($fs->getCollection() as $key => $value) {
                $output .= "$key: $value<br>";
                $cache = ltrim(\Configuration::CACHE_FOLDER, "./");
                $destination_files[] = str_replace('public', $cache, $value);
            }
            Filesystem::copy_files($fs->getCollection(), $destination_files);
        }

        return (string)$output;
    }


}

