<?php

namespace VanDragt\Carbon\App;

use Michelf\MarkdownExtra;
use VanDragt\Carbon\Sys;

if (!defined('BASE_FILEPATH')) {
    exit('No direct script access allowed');
}

class ModelPost extends Sys\Model
{

    // post model

    public $model = array(
        'yaml' => 'metadata',
        'markdown|html' => 'content',
    );


    public function sort($a, $b)
    {
        return strcmp($b->metadata->Published, $a->metadata->Published);
    }

    function contents($records, $Environment)
    {
        $loaded_classes = array(
             	'mdep' => new MarkdownExtra(),
             	'spyc' => new \Spyc(),
        );
        foreach ($records as $record) {
            $this->contents[] = $this->list_contents($record, $loaded_classes);
        }
        usort($this->contents, array($this, 'sort'));

        return $this;
    }

}
