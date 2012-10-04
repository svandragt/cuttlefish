<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Log {

	static function error( $message ) {
		error_log($message,0);
		echo($message. "<br>");
	}


	static function info( $message ) {
		$message = sprintf("[%s] (%s) %s", date('d/M/Y:H:i:s'), pathinfo(Http::server('PHP_SELF'), PATHINFO_FILENAME), $message . PHP_EOL);
		error_log($message, 3, Configuration::LOGS_FOLDER . '/mdblog.log');
	}

	static function warn( $message ) {
		$message = sprintf("[%s] (%s) WARN %s", date('d/M/Y:H:i:s'), pathinfo(Http::server('PHP_SELF'), PATHINFO_FILENAME), $message . PHP_EOL);
		error_log($message, 3, Configuration::LOGS_FOLDER . '/mdblog.log');
	}

}