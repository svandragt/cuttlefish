<?php if (!defined('BASE_FILEPATH')) {
    exit('No direct script access allowed');
}
printf("<div class='%s %s'>", $this->controller, $this->model);

switch (count($this->contents)) {
    case 0:
        // no content - new installation
        printf("<p> Please <a href='%s'>add content</a> to /%s/%s.</p>", href('/admin/new'), Configuration::CONTENT_FOLDER, $this->model);
        break;

    default:
	    $controller = $this->controller;
	    include __DIR__ . $controller . ".php";
        break;
}

print("</div>");
