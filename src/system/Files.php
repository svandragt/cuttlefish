<?php

namespace Cuttlefish;

class Files
{
    protected $files = [];

    public function __construct($dir_or_path, $ext = null)
    {
    	var_dump(get_call_stack());
    	die();
    	$dir_or_path = array_filter($dir_or_path);
        if (isset($dir_or_path['url'])) {
            $dir_or_path = Filesystem::convertUrlToPath($dir_or_path['url']);
        } elseif (isset($dir_or_path['path'])) {
            $dir_or_path = $dir_or_path['path'];
        }

        if (empty($dir_or_path)) {
        	$this->files = null;
        	return;
        }

        $files = $this->collect(realpath($dir_or_path), $ext);
        rsort($files);
        $this->files = $files;
    }


    /**
     * @return array
     *
     * @psalm-return list<mixed>
     */
    protected function collect(string $dir = ".", $filter = null): array
    {

        $files = array();

        // dir must exist
        if (false === is_dir($dir)) {
            return $files;
        }

        // get files
        if ($handle = opendir($dir)) {
            while (false !== ( $file = readdir($handle) )) {
                if ($file != "." && $file != "..") {
                    $file_path = $dir . DIRECTORY_SEPARATOR . $file;
                    if (is_dir($file_path)) {
                        $dir_files = $this->collect($file_path, $filter);
                        foreach ($dir_files as $ai) {
                            $files[] = $ai;
                        }
                    } elseif (( $filter === null ) || pathinfo($file_path, PATHINFO_EXTENSION) == $filter) {
                        $files[] = $file_path;
                    }
                }
            }
        }
        closedir($handle);

        return $files;
    }

    public function limit(int $max): array
    {
        $this->files = array_slice($this->files, 0, $max);

        return $this->files;
    }

    public function removeAll(): string
    {
        $output = '';

        foreach ($this->files as $file) {
            $file   = realpath($file);
            $output .= "Deleted: $file" . "<br>";
//            unlink($file);
        }

        return $output;
    }

    /**
     * @return array
     */
    public function files()
    {
        return $this->files;
    }
}
