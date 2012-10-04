<?php

class Feed {
	
	function __construct($models, $args)
	{
        $filename = $args['filename'];
        $xml = new SimpleXMLElement('<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom"></rss>'); 
        $xml->addChild('channel'); 
        $xml->channel->addChild('title', Configuration::SITE_TITLE); 
        $xml->channel->addChild('link', Url::root()); 
        $xml->channel->addChild('description', strip_tags(Configuration::SITE_MOTTO)); 
        $xml->channel->addChild('pubDate', date(DATE_RSS)); 
        $atom = $xml->channel->addChild('link','','http://www.w3.org/2005/Atom');
        $atom->addAttribute('href', Url::root( "/$filename" ));
        $atom->addAttribute('rel', 'self');
        $atom->addAttribute('type','application/rss+xml');

        foreach ($models as $model) {
            $item = $xml->channel->addChild('item'); 
            $item->addChild('title', $model->title); 
            $item->addChild('link', Url::root( $model->link )); 
            $item->addChild('guid', Url::root( $model->link )); 
            $item->addChild('description', $model->content); 
            $item->addChild('pubDate', date(DATE_RSS, strtotime($model->metadata->Published))); 
        }
        $this->xml = $xml;
	}

	function output() {
        header('Content-type: application/xml');
		echo $this->xml->asXML();
	}
}