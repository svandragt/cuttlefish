<?php

/**
 * Put functions specific to your application here. You can call these from the view templates.
 */

namespace Cuttlefish;

use Configuration;

if (!defined('BASE_DIR')) {
    exit('No direct script access allowed');
}

/**
 * Returns theme directory
 *
 * @param string $filename Optional filename.
 *
 * @return string link to theme directory
 */
function theme_path($filename = '')
{
    $theme_folder = Configuration::THEMES_FOLDER . DIRECTORY_SEPARATOR . Configuration::THEME . DIRECTORY_SEPARATOR;
    return  str_replace("\\", "/", $theme_folder) . $filename;
}
