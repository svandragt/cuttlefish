<?php

use Cuttlefish\App;

if (! defined('BASE_DIR')) {
    exit('No direct script access allowed');
}
printf("<div class='%s %s'>", $this->controller, $this->model);

$Controller = App::getInstance()->Router->Controller;

switch (count((array)$this->contents)) {
    case 0:
        // no content - new installation
        printf(
            "<p> Please add content to <code>%s</code>.</p>",
            $Controller->getContentPath()
        );
        break;

    default:
        $include = __DIR__ . DIRECTORY_SEPARATOR . $this->controller . ".php";
        include $include;
        break;
}

print("</div>");
