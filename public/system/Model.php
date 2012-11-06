<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Model {

	public $model = array(
	);

	public function __construct($records, $Environment) {
		try {
	    	if (array_unique ($this->model) !== $this->model) throw new Exception('Array values not unique for model');
		} catch (Exception $e) {
			Log::error($e->getMessage());		
		}
 		$this->contents($records, $Environment);
	}

	function limit($max) {
		$this->contents = array_slice($this->contents, 0, $max); 
		return $this;
	}	

	function contents($records, $Environment) {
		// implement $this->contents in your controller
	}

	function list_contents($record, $loaded_classes) {
		$content = new StdClass();
		$content->metadata = new StdClass();


		$url = new Url();
		$file = new File($record);

		$content_sections = preg_split( '/\R\R\R/',  trim(file_get_contents($file->path)), count($this->model));
		$section_keys     = array_keys($this->model);
		$section_values   = array_values($this->model);

		try {
			if (count($section_keys) != count($content_sections)) throw new Exception('Model (' . get_class($this) . ') definition (' . count($section_keys) .') does not match number of content sections (' . count($content_sections) . ').');
		} catch (Exception $e) {
			Log::error($e->getMessage());	
			exit();	
		}

		$content->link     = $url->file_to_url($file)->index()->abs()->url;


		for ($i = 0; $i < count($this->model); $i++) {
			$content_section = $content_sections[$i];
			$section_key = $section_keys[$i];
			$section_value = $section_values[$i];
			$content->$section_value = $this->section($content_section, $section_key, $section_value, $loaded_classes);		
		}

		return $content;

	}

	public function section($content_section, $section_key, $section_value, $loaded_classes) {
		// assign classes to their variables
		foreach ($loaded_classes as $class_name => $obj) $$class_name = $obj;

		$section = new StdClass();
		switch ($section_key) {
			case 'yaml':
				if ($spyc) $yaml = $spyc->YAMLLoadString($content_section);
				else       $yaml = $content_section;

				foreach ($yaml as $key => $value) $section->$key = $value;
				break;
			case 'markdown|html':
				$md_sections = preg_split( '/=\R/', trim($content_section), 2);	
				$title_sections   = preg_split( '/\R/' , trim($md_sections[0]), 2);	
				$section->title      = $title_sections[0];

				if ($mdep) $section->main = $mdep->transform($md_sections[1]);
				else       $section->main = $md_sections[1];
				break;
			
			default:
				break;
		}
		return $section;
		
	}

	public function sort($a, $b) {
		return strcmp($b, $a);
	}


}