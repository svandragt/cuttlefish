<?php

namespace VanDragt\Carbon;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Html {
	/**
	 * Html constructor.
	 * This code requires the following theme files:
	 * content.php, head.php, header.php, footer.php,sidebar.php
	 *
	 * @param $contents
	 * @param $shared
	 */
	function __construct( $contents, $shared ) {
		$Template = new Template(
			$shared['layout'],
			array_merge( array(
				'content' => new Template(
					'content.php',
					array_merge( array(
						'contents' => $contents,
					), $shared )
				),
				'head'    => new Template(
					'head.php',
					array_merge( array(), $shared )
				),
				'header'  => new Template(
					'header.php',
					array_merge( array(), $shared )
				),
				'footer'  => new Template(
					'footer.php',
					array_merge( array(), $shared )
				),
				'sidebar' => new Template(
					'sidebar.php',
					array_merge( array(), $shared )
				),
			), $shared )
		);
		$Template->render();
	}

}