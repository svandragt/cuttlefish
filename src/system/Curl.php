<?php

namespace Cuttlefish;

use RuntimeException;

class Curl
{
    protected $c;

    public function __construct()
    {
        if (! function_exists('curl_version')) {
            die('Please install the curl php extension to generate a static site.');
        }
        $this->c = curl_init();
    }

    /**
     * @param string $url
     * @param null $query_data
     * @param string $requestMethod
     *
     * @return bool|string
     */
    public function getURLContents(string $url, $query_data = null, string $requestMethod = 'GET')
    {
        // return the contents of an url with POST params and authentication based on settings;
        if ($requestMethod !== 'GET') {
            throw new RuntimeException(sprintf("%s method not implemented yet.", $requestMethod));
        }

        $query_string = '';
        if ($query_data) {
            $query_string = sprintf("?%s", http_build_query($query_data));
        }

        curl_setopt($this->c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->c, CURLOPT_VERBOSE, false);
        curl_setopt($this->c, CURLOPT_URL, $url . $query_string);

        $contents = curl_exec($this->c);

        if ($contents) {
            return $contents;
        }
        return false;
    }

    public function close(): void
    {
        curl_close($this->c);
    }
}
