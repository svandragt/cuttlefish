<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ModelPost extends Model {

	// post model

	public $model = array(
		'yaml' => 'metadata',
		'markdown|html' => 'content',
	);


	public function sort($a, $b) {
		return strcmp($b->metadata->Published, $a->metadata->Published);
	}

	function contents($records, $Environment) {
		$loaded_classes = array(
			'mdep' => ($Environment->class_loaded('MarkdownExtra_Parser')) ? $mdep = new MarkdownExtra_Parser : null,
			'spyc' => ($Environment->class_loaded('Spyc')) ? $spyc = new Spyc : null,
		);
		foreach ($records as $record) {
			$this->contents[] = $this->list_contents($record, $loaded_classes);
		}
		usort ( $this->contents, array($this, 'sort'));
		$limit = Configuration::POSTS_HOMEPAGE;
    	$this->limit($limit);
	}
	
}