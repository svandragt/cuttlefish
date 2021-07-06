<?php

/** @noinspection ForgottenDebugOutputInspection */

namespace src;

use Configuration;

class Log
{
    protected const FILENAME_TEMPLATE = '/app.log';

    protected static function getUniqueFilename(): string
    {
        return self::FILENAME_TEMPLATE;
    }

    public static function error(string $message): void
    {
        error_log($message, 0);
        echo($message . "<br>");
    }

    public static function debug(string $message): void
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

    public static function info(string $message): void
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

    public static function warn(string $message): void
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
