<?php

namespace Cuttlefish;

use Configuration;

class Url
{
    public string $url_relative = '';
    public string $url_absolute = '';

    public function __construct($path = null)
    {
        if (is_string($path)) {
            $this->setUrl($path);
        }
    }

    protected function setUrl(string $path): void
    {
        $this->url_relative = Configuration::INDEX_PAGE . $path;
        $this->url_absolute = $this->protocol() . $_SERVER['HTTP_HOST'] . $this->url_relative;
    }

    /**
     * Returns protocol part of an internal url
     * Source: http://stackoverflow.com/questions/4503135/php-get-site-url-protocol-http-vs-https
     *
     * @return string correct protocol dependent url
     */
    protected function protocol(): string
    {
        $protocol = 'http://';
        if ((! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] === 443) {
            $protocol = 'https://';
        }

        return $protocol;
    }

    /**
     * Converts a file to an url.
     * make sure to call Url->url_absolute after.
     *
     * @param File $file_object File object
     *
     * @return self url object
     */
    public static function fromFile(File $file_object): self
    {
        $url = str_replace(DIRECTORY_SEPARATOR, "/", $file_object->path);
        $url = '/' . ltrim($url, '/');

        // Content paths
        $content_folder = realpath(Configuration::CONTENT_FOLDER);
        $relative_url = $url;
        if (strrpos($url, $content_folder) !== false) {
            $relative_url = str_replace([
                $content_folder,
                '.' . Configuration::CONTENT_EXT,
            ], '', $url);
        }

        Log::debug(__FUNCTION__ . " relative_url: $relative_url");
        $Url = new Url();
        $Url->setUrl($relative_url);

        return $Url;
    }
}
