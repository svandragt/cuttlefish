<?php

use Michelf\MarkdownExtra;

class ModelPage extends Cuttlefish\Model
{
    // page model

    public $model = array(
        'markdown|html' => 'content',
    );

    public function contents($records)
    {
        $loaded_classes = array(
            'mdep' => new MarkdownExtra(),
        );

        foreach ($records as $record) {
            $this->contents[] = $this->list_contents($record, $loaded_classes);
        }
    }
}
