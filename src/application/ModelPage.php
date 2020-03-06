<?php

use Michelf\MarkdownExtra;

class ModelPage extends Cuttlefish\Model
{
    // page model

    public $model = array(
        'markdown|html' => 'content',
    );

    /**
     * @return void
     */
    public function contents($records)
    {
        $loaded_classes = array(
            'mdep' => new MarkdownExtra(),
        );

        foreach ($records as $record) {
            $this->contents[] = $this->listContents($record, $loaded_classes);
        }
    }
}
