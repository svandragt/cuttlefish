<?php

namespace Cuttlefish;

// @link http://stackoverflow.com/questions/62617/whats-the-best-way-to-separate-php-code-and-html
class Template
{

    protected $args;
    protected $file;

    public function __construct($file, $args = array())
    {
        $this->file = $file;
        $this->args = $args;
    }

    public function render(): void
    {
        $path = BASE_FILEPATH . theme_dir() . "/views" . DIRECTORY_SEPARATOR . $this->file;
        require $path;
    }
}
