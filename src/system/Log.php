<?php

namespace VanDragt\Carbon;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Log {

	static function error( $message, $message_type = 'ERROR' ) {
		self::error_log( $message, $message_type );
		echo( $message . "<br>" );
	}

	static function error_log( $message, $message_type = 'ERROR', $destination = null ) {
		$message = sprintf( "[%s] (%s) %s %s", date( 'd/M/Y:H:i:s' ), pathinfo( $_SERVER['PHP_SELF'], PATHINFO_FILENAME ), $message_type, $message . PHP_EOL );
		error_log( $message, 3, $destination );
	}

	static function debug( $message ) {
		if ( \Configuration::DEBUG_ENABLED ) {
			self::error_log( $message, 'DEBUG' );
		}
	}

	static function info( $message ) {
		self::error_log( $message, 'INFO' );
	}

	static function warn( $message ) {
		self::error_log( $message, 'WARN' );
	}

}