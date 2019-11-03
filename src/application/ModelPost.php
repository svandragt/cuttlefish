<?php

use Michelf\MarkdownExtra;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class ModelPost extends Mana\Model {

	public $model = array(
		'yaml'          => 'metadata',
		'markdown|html' => 'content',
	);

	public function sortByPublished( $a, $b ) {
		return strcmp( $b->metadata->Published, $a->metadata->Published );
	}

	function contents( $records ) {
		$loaded_classes = array(
			'mdep' => new MarkdownExtra(),
			'spyc' => new Spyc(),
		);
		foreach ( $records as $record ) {
			$this->contents[] = $this->list_contents( $record, $loaded_classes );
		}
		usort( $this->contents, array( $this, 'sortByPublished' ) );

		return $this;
	}
}
