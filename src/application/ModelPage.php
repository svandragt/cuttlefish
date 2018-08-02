<?php

use Michelf\MarkdownExtra;
use VanDragt\Carbon;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class ModelPage extends Carbon\Model {
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
