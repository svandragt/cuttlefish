<?php

use Michelf\MarkdownExtra;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class ModelPage extends Cuttlefish\Model {
	// page model

	public $model = array(
		'markdown|html' => 'content',
	);

	function contents( $records ) {
		$loaded_classes = array(
			'mdep' => new MarkdownExtra(),
		);

		foreach ( $records as $record ) {
			$this->contents[] = $this->list_contents( $record, $loaded_classes );
		}
	}
}
