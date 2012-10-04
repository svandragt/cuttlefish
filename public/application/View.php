<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class View {

    static function feed($models, $args) {
        $feed = new Feed($models, $args);
        $feed->output();
    }

    static function image($file, $args) {
        $image = new Image($file);
        $image->output();
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