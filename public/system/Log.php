<?php 

namespace VanDragt\Carbon\Sys; 

if (!defined('BASE_FILEPATH'))
{
	exit('No direct script access allowed');
}

class Log
{

	const FILENAME_TEMPLATE = '/carbon-%s.log';

	static function error($message)
	{
		error_log($message, 0);
		echo($message . "<br>");
	}


	static function debug($message)
	{
		if (\Configuration::DEBUG_ENABLED)
		{
			$message = sprintf("[%s] (%s) DEBUG %s", date('d/M/Y:H:i:s'), pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME), $message . PHP_EOL);
			error_log($message, 3, \Configuration::LOGS_FOLDER . self::filename_per_request());
		}
	}

	static function filename_per_request()
	{
		return sprintf(self::FILENAME_TEMPLATE, date("Y-m-d_H-m-s"));
	}

	static function info($message)
	{
		$message = sprintf("[%s] (%s) INFO %s", date('d/M/Y:H:i:s'), pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME), $message . PHP_EOL);
		error_log($message, 3, Configuration::LOGS_FOLDER . self::filename());
	}

	static function filename()
	{
		return sprintf(self::FILENAME_TEMPLATE, date("Y-m-d"));
	}

	static function warn($message)
	{
		$message = sprintf("[%s] (%s) WARN %s", date('d/M/Y:H:i:s'), pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME), $message . PHP_EOL);
		error_log($message, 3, Configuration::LOGS_FOLDER . self::filename());
	}

}