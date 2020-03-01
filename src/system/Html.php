<?php

namespace Cuttlefish;

if (! defined('BASE_FILEPATH')) {
    exit('No direct script access allowed');
}

class Html
{
    /**
     * Html constructor.
     * This code requires the following theme files:
     * content.php, layout.php
     *
     * @param array $contents Array of content items
     * @param array $shared Array of shared data available to add templates
     */
    public function __construct($contents, $shared)
    {
        $Template = new Template(
            $shared['layout'],
            array_merge(array(
                'content' => new Template(
                    'content.php',
                    array_merge(array(
                        'contents' => $contents,
                    ), $shared)
                ),
            ), $shared)
        );
        $Template->render();
    }
}
