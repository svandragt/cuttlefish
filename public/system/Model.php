<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Model extends Extension {

	public $model = array(
	);

	function __construct($parent) {
		parent::__construct($parent);
	}


	public function init() {
		parent::init();
		try {
	    	if (array_unique ($this->model) !== $this->model) throw new Exception('Array values not unique for model');
		} catch (Exception $e) {
			Log::error($e->getMessage());		
		}
 		$this->load_contents();
		usort ( $this->contents, array($this, 'sort'));

	}

	function limit($max) {
		$this->contents = array_slice($this->contents, 0, $max); 
		return $this;
	}	

	function load_contents() {
		$records = $this->_parent->Records->collection;
		$Environment = $this->_parent->_parent->Environment;
		$loaded_classes = array(
			'mdep' => ($Environment->class_loaded('MarkdownExtra_Parser')) ? $mdep = new MarkdownExtra_Parser : null,
			'spyc' => ($Environment->class_loaded('Spyc')) ? $spyc = new Spyc : null,
		);
		foreach ($records as $record) $this->contents[] = $this->list_contents($record, $loaded_classes);
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
			if (count($content_sections) != count($section_keys)) throw new Exception('Model definition does not match number of content sections.');
		} catch (Exception $e) {
			Log::error($e->getMessage());		
		}

		// print_r($url->file_path_to_url($file)->index());
		$content->link     = $url->file_path_to_url($file)->index()->abs()->url;


		for ($i = 0; $i < count($this->model); $i++) {
			$content_section = $content_sections[$i];
			$section_key = $section_keys[$i];
			$section_value = $section_values[$i];
			$content->$section_value = $this->load_section($content_section, $section_key, $section_value, $loaded_classes);		
		}

		return $content;

	}

	public function load_section($content_section, $section_key, $section_value, $loaded_classes) {
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