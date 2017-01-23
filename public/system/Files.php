<?php
namespace VanDragt\Carbon;

if (!defined('BASE_FILEPATH')) {
    exit('No direct script access allowed');
}

class Files extends Collection
{

    public function __construct($dir_or_path, $ext = NULL)
    {
        if (isset($dir_or_path['url'])) {
            $dir_or_path = Filesystem::url_to_path($dir_or_path['url']);
        } elseif (isset($dir_or_path['path'])) {
            $dir_or_path = $dir_or_path['path'];
        }
        $collection = $this->collect($dir_or_path, $ext);
        rsort($collection);
        $this->setCollection($collection);

        return $this;
    }


    private function collect($dir = ".", $filter = NULL)
    {
        Log::debug(__FUNCTION__ . " called.");
        $files = array();

        // dir must exist
        if (false == is_dir($dir)) {
            return $files;
        }

        // get files
        if ($handle = opendir($dir)) {
            while (FALSE !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    $file_path = $dir . DIRECTORY_SEPARATOR . $file;
                    if (is_dir($file_path)) {
                        $dir_files = $this->collect($file_path, $filter);
                        if (count($dir_files) > 0) {
                            $files = array_merge($files, $dir_files);
                        }
                    } elseif ((is_null($filter)) || pathinfo($file_path, PATHINFO_EXTENSION) == $filter) {
                        $files[] = $file_path;
                    }
                }
            }
        }
        closedir($handle);

        return $files;
    }

    public function limit($max)
    {
        $this->setCollection(array_slice($this->getCollection(), 0, $max));

        return $this;
    }

    public function remove_all($is_directory_removable = FALSE)
    {
        $output = '';
        Log::debug(__FUNCTION__ . " called.");
        foreach ($this->getCollection() as $file) {
            $file = realpath($file);
            $output .= "Deleted: $file" . "<br>";
            unlink($file);
        }

        return $output;
    }

}
