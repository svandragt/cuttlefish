<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

// PHP 5 - http://stackoverflow.com/questions/62617/whats-the-best-way-to-separate-php-code-and-html
class Template {
    private $args;
    private $file;

    public function __get($name) {
        return $this->args[$name];
    }

    public function __construct($file, $args = array()) {
        $this->file = $file;
        $this->args = $args;
    }

    public function render() {
        $path =BASEPATH . THEME_DIR . "views" . DIRECTORY_SEPARATOR . $this->file;
        $result = include $path;
	if (! $result) echo "Cannot include $path";
    }
}
