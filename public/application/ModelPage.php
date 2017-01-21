<?php

namespace VanDragt\Carbon\App;

use VanDragt\Carbon\Sys;

if (!defined('BASE_FILEPATH')) {
    exit('No direct script access allowed');
}

class ModelPage extends Sys\Model
{

    // page model

    public $model = array(
        'markdown|html' => 'content',
    );

    function contents($records, $Environment)
    {
        $loaded_classes = array(
            'mdep' => ($Environment->class_loaded('MarkdownExtra_Parser')) ? $mdep = new MarkdownExtra_Parser : NULL,
        );
        foreach ($records as $record) {
            $this->contents[] = $this->list_contents($record, $loaded_classes);
        }
    }

}
