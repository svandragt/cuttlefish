<?php

namespace Cuttlefish;

use Configuration;

class Log
{
    protected const FILENAME_TEMPLATE = '/cuttlefish.log';

    protected static function getUniqueFilename()
    {
        return sprintf(self::FILENAME_TEMPLATE, date("Y-m-d_H-m-s"));
    }

    public static function error($message)
    {
        error_log($message, 0);
        echo( $message . "<br>" );
    }

    public static function debug($message)
    {
        if (Configuration::DEBUG_ENABLED) {
            $message = sprintf(
                "[%s] (%s) DEBUG %s",
                date('d/M/Y:H:i:s'),
                pathinfo(
                    $_SERVER['PHP_SELF'],
                    PATHINFO_FILENAME
                ),
                $message . PHP_EOL
            );
            error_log($message, 3, Configuration::LOGS_FOLDER . self::getUniqueFilename());
        }
    }

    public static function info($message)
    {
        $message = sprintf(
            "[%s] (%s) INFO %s",
            date('d/M/Y:H:i:s'),
            pathinfo(
                $_SERVER['PHP_SELF'],
                PATHINFO_FILENAME
            ),
            $message . PHP_EOL
        );
        error_log($message, 3, Configuration::LOGS_FOLDER . self::FILENAME_TEMPLATE);
    }

    public static function warn($message)
    {
        $message = sprintf(
            "[%s] (%s) WARN %s",
            date('d/M/Y:H:i:s'),
            pathinfo(
                $_SERVER['PHP_SELF'],
                PATHINFO_FILENAME
            ),
            $message . PHP_EOL
        );
        error_log($message, 3, Configuration::LOGS_FOLDER . self::FILENAME_TEMPLATE);
    }
}
