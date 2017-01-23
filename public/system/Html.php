<?php

namespace VanDragt\Carbon;

if (!defined('BASE_FILEPATH')) {
    exit('No direct script access allowed');
}

class Html
{

    function __construct($contents, $shared)
    {
        $template = new Template(
            $shared['layout'],
            array_merge(array(
                'content' => new Template(
                    'content.php',
                    array_merge(array(
                        'contents' => $contents,
                    ), $shared)
                ),
                'head' => new Template(
                    'head.php',
                    array_merge(array(), $shared)
                ),
                'header' => new Template(
                    'header.php',
                    array_merge(array(), $shared)
                ),
                'footer' => new Template(
                    'footer.php',
                    array_merge(array(), $shared)
                ),
                'sidebar' => new Template(
                    'sidebar.php',
                    array_merge(array(), $shared)
                ),
            ), $shared)
        );
        $template->render();
    }



    //    static function feed($models, $args) {
    //        $feed = new Feed($models, $args);
    //        $feed->output();
    //    }

    //    static function file($file, $args) {
    //        $file = new File($file);
    //        $file->output();
    //    }

    // public function template($models , $shared) {

    // }
}