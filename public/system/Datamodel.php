<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Datamodel {

	public $metadata = null;
	
	function __construct( $args, $section_types) {
		Log::debug('New datamodel started');

		$this->metadata = new StdClass();
		foreach ($args as $key => $value) $this->$key = $value;
		Log::debug(print_r($args,true));


		try {
	    	if (array_unique ($section_types) !== $section_types) throw new Exception('Array values not unique');
		} catch (Exception $e) {
			Log::debug($e->getMessage());		
			Log::error($e->getMessage());		
			
		}
		Log::debug("filepath: ". $this->file_path);




        // Call the Model constructor
		$this->link     = Url::index(Url::file_path_to_url($this->file_path));
		Log::debug("got to here");
		
		$this->sections = preg_split( '/\R\R\R/',  trim(file_get_contents($this->file_path)), 2);
		$section_keys   = array_keys($section_types);
		$section_values = array_values($section_types);

		try {
			if (count($this->sections) != count($section_keys)) throw new Exception('Model definition does not match number of content sections.');
		} catch (Exception $e) {
			Log::debug($e->getMessage());		
			Log::error($e->getMessage());		
		}

		Log::debug("got to here");
		$mdep = null;
		$spyc = null;
		if (Ext::class_loaded('MarkdownExtra_Parser')) $mdep = new MarkdownExtra_Parser;
		if (Ext::class_loaded('Spyc'))                 $spyc = new Spyc;

		for ($i = 0; $i < count($section_types); $i++) { 
			$section_key   = $section_keys[$i];
			$section_value = $section_values[$i];
			switch ($section_key) {
				case 'yaml':
					if ($spyc) $yaml = $spyc->YAMLLoadString($this->sections[$i]);
					else       $yaml = $this->sections[$i];

					foreach ($yaml as $key => $value) $this->$section_value->$key = $value;

					break;
				case 'markdown|html':
					$content_sections = preg_split( '/=\R/', trim($this->sections[$i]), 2);	
					$title_sections   = preg_split( '/\R/' , trim($content_sections[0]), 2);	
					$this->title      = $title_sections[0];

					if ($mdep) $this->$section_value = $mdep->transform($content_sections[1]);
					else       $this->$section_value = $content_sections[1];
					break;
				
				default:
					# code...
					break;
			}
			# code...
		}
		Log::debug('New datamodel constructed');


    }
}