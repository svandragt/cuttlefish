<?php

namespace Cuttlefish;

class Html
{
    /**
     * Html constructor.
     * This code requires the following theme files:
     * content.php, $shared['layout'] eg. layout.php
     *
     * @param array $contents Array of content items
     * @param array $shared Array of shared data available to add templates
     */
    public function __construct(array $contents, array $shared)
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
