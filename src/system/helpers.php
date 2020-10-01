<?php

namespace Cuttlefish;

use Configuration;

if (! defined('BASE_FILEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Returns theme directory
 *
 * @return string link to theme directory
 */
function theme_dir($filename = '')
{
    $theme_folder = Configuration::THEMES_FOLDER . DIRECTORY_SEPARATOR . Configuration::THEME . DIRECTORY_SEPARATOR;

    return BASE_PATH . str_replace("\\", "/", $theme_folder) . $filename;
}

// put functions specific to your application here. You can call these from the view templates.
// Todo is this actually working?
