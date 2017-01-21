<?php 

namespace VanDragt\Carbon\Sys;

if (!defined('BASE_FILEPATH'))
{
	exit('No direct script access allowed');
}

class Feed
{

	function __construct($posts)
	{
		$page_url = new Url();
		$xml = new SimpleXMLElement('<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom"></rss>');
		$xml->addChild('channel');
		$xml->channel->addChild('title', Configuration::SITE_TITLE);
		$xml->channel->addChild('link', $page_url->index($_SERVER['PATH_INFO'])->abs()->url);
		$xml->channel->addChild('description', strip_tags(Configuration::SITE_MOTTO));
		$xml->channel->addChild('pubDate', date(DATE_RSS));
		$atom = $xml->channel->addChild('link', '', 'http://www.w3.org/2005/Atom');
		$atom->addAttribute('href', $page_url->url);
		$atom->addAttribute('rel', 'self');
		$atom->addAttribute('type', 'application/rss+xml');

		foreach ($posts as $post)
		{
			$item = $xml->channel->addChild('item');
			$item->addChild('title', $post->content->title);
			$item->addChild('link', $post->link);
			$item->addChild('guid', $post->link);
			$item->addChild('description', $post->content->main);
			$item->addChild('pubDate', date(DATE_RSS, strtotime($post->metadata->Published)));
		}
		$this->xml = $xml;
		$this->render();
	}

	function render()
	{
		header('Content-type: application/xml');
		echo $this->xml->asXML();
	}
}