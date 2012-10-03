<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class View {

    static function feed($models, $args)
    {
        header('Content-type: application/xml');
        $filename = $args['filename'];
        $xml = new SimpleXMLElement('<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom"></rss>'); 
        $xml->addChild('channel'); 
        $xml->channel->addChild('title', Configuration::SITE_TITLE); 
        $xml->channel->addChild('link', Theming::root()); 
        $xml->channel->addChild('description', strip_tags(Configuration::SITE_MOTTO)); 
        $xml->channel->addChild('pubDate', date(DATE_RSS)); 
        $atom = $xml->channel->addChild('link','','http://www.w3.org/2005/Atom');
        $atom->addAttribute('href', Theming::root() . "/$filename");
        $atom->addAttribute('rel', 'self');
        $atom->addAttribute('type','application/rss+xml');

        foreach ($models as $model) {
            $item = $xml->channel->addChild('item'); 
            $item->addChild('title', $model->title); 
            $item->addChild('link', Theming::root().$model->link); 
            $item->addChild('guid', Theming::root().$model->link); 
            $item->addChild('description', $model->content); 
            $item->addChild('pubDate', date(DATE_RSS, strtotime($model->metadata->Published))); 
        }
        echo $xml->asXML();
    }

	static function template($models , $shared) {
		// $models = (is_array($models)) ? $models : array($models);
		$template = new Template(
            $shared['layout'], 
            array_merge(array(
                'content' => new Template(
                	'content.php',
                    array_merge(array(
                    	'models' => $models
                    ),$shared)
            	),
                'head' => new Template(
                	'head.php',
                    array_merge(array(),$shared)
            	),
                'header' => new Template(
                	'header.php',
                    array_merge(array(),$shared)
            	),
            	'footer' => new Template(
                	'footer.php',
                    array_merge(array(),$shared)
                ),
           		'sidebar' => new Template(
              		'sidebar.php',
                    array_merge(array(),$shared)
            	)
            ), $shared)
        );
		$template->render();				
		
	}
}