<?php

class View {
	
	static function template($models , $layout = 'layout.php') {
		$models = (is_array($models)) ? $models : array($models);

		$content = array();

		$as = array(
        // 'title' => Configuration::SITE_TITLE,
		);
		if (!is_null($content)) {
			$template = new Template(
	            $layout, 
	            array_merge(array(
	                'content' => new Template(
	                	'content.php',
	                    array_merge(array(
	                    	'models' => $models
	                    ),$as)
	            	),
	                'head' => new Template(
	                	'head.php',
	                    array_merge(array(),$as)
	            	),
	                'header' => new Template(
	                	'header.php',
	                    array_merge(array(),$as)
	            	),
	            	'footer' => new Template(
	                	'footer.php',
	                    array_merge(array(),$as)
	                ),
	           		'sidebar' => new Template(
	              		'sidebar.php',
	                    array_merge(array(),$as)
	            	)
	            ), $as)
	        );
			$template->render();				
		}
	}
}