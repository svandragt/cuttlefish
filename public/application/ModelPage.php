<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ModelPage extends Model {

	// page model

	public $model = array(
		'markdown|html' => 'content',
	);

	function contents($records, $Environment) {
		$loaded_classes = array(
			'mdep' => ($Environment->class_loaded('MarkdownExtra_Parser')) ? $mdep = new MarkdownExtra_Parser : null,
		);
		foreach ($records as $record) {
			$this->contents[] = $this->list_contents($record, $loaded_classes);
		}
	}

}
