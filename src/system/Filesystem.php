<?php

namespace Cuttlefish;

class Filesystem
{

    public static function requireFolder($folder)
    {
        if (! is_dir($folder)) {
            @mkdir($folder, 0777, true);
            if (! is_dir($folder)) {
                Log::error("Please manually create <code>$folder</code>");
                return false;
            } else {
                Log::info("Created $folder");
                return true;
            }
        }
    }

    public static function convertUrlToPath($url)
    {
        // takes /content/pages/index and returns path
        $path = BASE_FILEPATH . ltrim(str_replace('/', DIRECTORY_SEPARATOR, $url), '/');
        Log::debug("$url converted to $path");

        return $path;
    }

    public static function copyFiles($source_files, $destination_files)
    {
        $i = 0;
        foreach ($source_files as $key => $value) {
            $destination_file = $destination_files[ $i ];

            $dirname = pathinfo($destination_file, PATHINFO_DIRNAME);
            if (! is_dir($dirname)) {
                mkdir($dirname, 0777, true);
            }
            copy($value, $destination_file);
            $i++;
        }
    }

    public static function subdirs($path, $recursive = false)
    {
        $dirs = array();
        foreach (glob($path . DIRECTORY_SEPARATOR . "*") as $file) {
            if (is_dir($file)) {
                $dirs[] = $file;
                // not really recursive then is it when it calls another function
                if ($recursive) {
                    self::removeDirs($file);
                }
            }
        }

        return $dirs;
    }

    public static function removeDirs($path)
    {
        $empty = true;
        foreach (glob($path . DIRECTORY_SEPARATOR . "*") as $file) {
            $empty &= is_dir($file) && self::removeDirs($file);
        }

        return $empty && rmdir($path);
    }
}
