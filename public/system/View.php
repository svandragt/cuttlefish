<?php

class View {
	
	static function template($data , $layout = 'layout.php') {
		$data = (is_array($data)) ? $data : array($data);

		$articles = array();
		foreach ($data as $data_item) {
			$articles[] = $data_item->content;
		}



		$as = array(
        // 'title' => Configuration::SITE_TITLE,
		);
		if (!is_null($articles)) {
			$template = new Template(
	            $layout, 
	            array_merge(array(
	                'articles' => new Template(
	                	'articles.php',
	                    array_merge(array(
	                    	'articles' => $articles
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