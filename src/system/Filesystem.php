<?php

namespace VanDragt\Carbon;

if (!defined('BASE_FILEPATH')) {
    exit('No direct script access allowed');
}

class Filesystem
{

    static function ensure_folder_exists($folder)
    {

	    if ( ! is_dir( $folder ) ) {
            if (!mkdir($folder, 0777, TRUE)) {
                Log::error("Please manually create <code>$folder</code>");
            } else {
                Log::info("Created $folder");
            }
        }
    }

    static function url_to_path($url)
    {
        // takes /content/pages/index and returns path

	    $path = BASE_FILEPATH . ltrim( str_replace( '/', DIRECTORY_SEPARATOR, $url ), '/' );
        Log::debug("$url converted to $path");

        return $path;
    }

    static function copy_files($source_files, $destination_files)
    {

	    $i = 0;
        foreach ($source_files as $key => $value) {
            $destination_file = $destination_files[$i];

            $dirname = pathinfo($destination_file, PATHINFO_DIRNAME);
            if (!is_dir($dirname)) {
                mkdir($dirname, 0777, TRUE);
            }
            copy($value, $destination_file);
            $i++;
        }
    }

    static function subdirs($path, $recursive = FALSE)
    {
        $dirs = array();
        foreach (glob($path . DIRECTORY_SEPARATOR . "*") as $file) {
            if (is_dir($file)) {
                $dirs[] = $file;
                // not really recursive then is it when it calls another function
                if ($recursive) {
                    self::remove_dirs($file);
                }
            }
        }

        return $dirs;
    }

    static function remove_dirs($path)
    {
        $empty = TRUE;
        foreach (glob($path . DIRECTORY_SEPARATOR . "*") as $file) {
            $empty &= is_dir($file) && self::remove_dirs($file);
        }

        return $empty && rmdir($path);
    }


}
