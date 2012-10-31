<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Feed {
	
	function __construct($posts)
	{
        $xml = new SimpleXMLElement('<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom"></rss>'); 
        $xml->addChild('channel'); 
        $xml->channel->addChild('title', Configuration::SITE_TITLE); 
        $xml->channel->addChild('link', $_SERVER['PATH_INFO']); 
        $xml->channel->addChild('description', strip_tags(Configuration::SITE_MOTTO)); 
        $xml->channel->addChild('pubDate', date(DATE_RSS)); 
        $atom = $xml->channel->addChild('link','','http://www.w3.org/2005/Atom');
        $atom->addAttribute('href', $_SERVER['PATH_INFO'] );
        $atom->addAttribute('rel', 'self');
        $atom->addAttribute('type','application/rss+xml');

        foreach ($posts as $post) {
            $url = new Url();
            $url = $url->index($post->link)->abs()->url;
            $item = $xml->channel->addChild('item'); 
            $item->addChild('title', $post->content->title); 
            $item->addChild('link', $url); 
            $item->addChild('guid', $url);  
            $item->addChild('description', $post->content->main); 
            $item->addChild('pubDate', date(DATE_RSS, strtotime($post->metadata->Published))); 
        }
        $this->xml = $xml;
        $this->render();
	}

	function render() {
        	header('Content-type: application/xml');
		echo $this->xml->asXML();
	}
}