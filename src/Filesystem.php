<?php

namespace Cuttlefish;

use RuntimeException;

class Filesystem
{

    /**
     * @return true
     */
    public static function requireFolder(string $folder): bool
    {
        if (! is_dir($folder)) {
            if (! mkdir($folder, 0777, true) && ! is_dir($folder)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $folder));
            }
            Log::info("Created $folder");
        }
        return true;
    }

    /**
     * FIXME: This is a pointless function
     *
     * @param string $url
     *
     * @return string
     */
    public static function convertUrlToPath(string $url): string
    {
        // takes /content/pages/index and returns path
        $path = BASE_FILEPATH . ltrim(str_replace('/', DIRECTORY_SEPARATOR, $url), '/');
        Log::debug("$url converted to $path");

        return $path;
    }

    /**
     * @param string[] $destination_files
     *
     * @return void
     */
    public static function copyFiles(array $source_files, array $destination_files): void
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

    /**
     * @param false|string $path
     * @param false $recursive
     *
     * @return string[]
     *
     * @psalm-return list<string>
     */
    public static function subdirs($path, bool $recursive = false): array
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

    /**
     * @param false|string $path
     *
     * @return bool
     */
    public static function removeDirs($path): bool
    {
        $empty = true;
        foreach (glob($path . DIRECTORY_SEPARATOR . "*") as $file) {
            $empty &= is_dir($file) && self::removeDirs($file);
        }

        return $empty && rmdir($path);
    }
}
