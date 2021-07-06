<?php

namespace src;

use Exception;

class File
{
    protected $ext;
    protected $mime;
    public $is_relative;
    public $path;

    public function __construct(string $file_path)
    {
        try {
            if (! file_exists($file_path)) {
                throw new Exception("'$file_path' not found :(");
            }
            if (! is_readable($file_path)) {
                throw new Exception("'$file_path' is unreadable!");
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            Log::error($e->getMessage());
            exit();
        }
        $this->path = $file_path;
        $this->ext  = pathinfo($file_path, PATHINFO_EXTENSION);
        $this->mime = $this->getMimetype();
    }

    /**
     * @return false|string
     */
    protected function getMimetype()
    {
        switch ($this->ext) {
            case 'css': // php cannot detect css
                return "text/css";

            default:
                return $this->getMimetypeFromFile($this->path);
        }
    }

    /**
     * @return false|string
     */
    protected function getMimetypeFromFile(string $filename)
    {
        if (is_file($filename)) {
            return mime_content_type($filename);
        }

        return false;
    }

    public function relative(): self
    {
        if (! $this->is_relative) {
            $root_path         = '/';
            $this->path        = str_replace($root_path, "", $this->path);
            $this->is_relative = true;
        }

        return $this;
    }

    public function render(): void
    {
        $mime = $this->mime;
        header("Content-Type: $mime");
        readfile($this->path);
    }
}
