<?php if (!defined('BASE_FILEPATH'))
{
	exit('No direct script access allowed');
}

class Url
{

	public $url;
	public $is_relative; // made absolute?
	public $is_prefixed; // been through index function

	// all url functions relative, except root

	function __construct()
	{
	}

	/**
	 * Returns an absolute url from a relative/absolute url
	 *
	 * @return object url object
	 */
	function abs()
	{
		// make a relative url absolute
		if ($this->is_relative)
		{
			$this->url = $this->protocol() . $_SERVER['HTTP_HOST'] . $this->url;
			$this->is_relative = FALSE;
		}

		return (object)$this;
	}

	/**
	 * Returns protocol part of an internal url
	 * Source: http://stackoverflow.com/questions/4503135/php-get-site-url-protocol-http-vs-https
	 *
	 * @return string correct protocol dependent url
	 */
	function protocol()
	{
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

		return (string)$protocol;
	}

	/**
	 * Converts a file to an url.
	 * make sure to call Url->index($url) after.
	 *
	 * @param  object $file_object File object
	 *
	 * @return object              url object
	 */
	function file_to_url($file_object)
	{
		$file_object = $file_object->relative();

		$relative_url = str_replace(DIRECTORY_SEPARATOR, "/", $file_object->path);
		$relative_url = '/' . ltrim($relative_url, '/');
		Log::debug(__FUNCTION__ . " relative_url: $relative_url");

		if (!strrpos($relative_url, Configuration::CONTENT_FOLDER) === FALSE)
		{
			$relative_url = str_replace(Configuration::CONTENT_FOLDER . '/', '', $relative_url);
			$relative_url = str_replace('.' . Configuration::CONTENT_EXT, '', $relative_url);
		}

		$this->url = $relative_url;
		$this->is_relative = TRUE;
		$this->is_prefixed = FALSE;

		return (object)$this;
	}

	/**
	 * Returns index_page independent url
	 *
	 * @param  string $url url
	 *
	 * @return object      url object
	 */
	function index($url = NULL)
	{
		// makes sure links work index_page independent	
		if (!$this->is_prefixed)
		{
			$this->url = (is_null($url)) ? $this->url : $url;
			$this->url = Configuration::INDEX_PAGE . $this->url;
			$this->is_prefixed = TRUE;
			$this->is_relative = TRUE;
		}

		return (object)$this;
	}

}