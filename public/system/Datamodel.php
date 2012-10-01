<?php

class Datamodel {
	
	function __construct($file_path, $section_types) {

    	if (array_unique ($section_types) !== $section_types) throw new Exception('Array values not unique');

        // Call the Model constructor
   		$this->file_path = $file_path;
		$this->link      = Theming::content_url($file_path);
		list(, $this->caller) = debug_backtrace(false);

		$this->sections = preg_split( '/\R\R/',  trim(file_get_contents($this->file_path)), 2);
		$section_keys   = array_keys($section_types);
		$section_values = array_values($section_types);

		if (count($this->sections) != count($section_keys)) throw new Exception('Model definition does not match number of content sections.');

		$mdep = null;
		$spyc = null;
		if (Ext::class_loaded('MarkdownExtra_Parser')) $mdep = new MarkdownExtra_Parser;
		if (Ext::class_loaded('Spyc'))                 $spyc = new Spyc;

		for ($i = 0; $i < count($section_types); $i++) { 
			$section_key   = $section_keys[$i];
			$section_value = $section_values[$i];
			switch ($section_key) {
				case 'yaml':
					if ($spyc) $this->$section_value = $spyc->YAMLLoadString($this->sections[$i]);
					else       $this->$section_value = $this->sections[$i];
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


    }
}