<?php

use Michelf\MarkdownExtra;

class ModelPost extends Cuttlefish\Model
{

    public $model = array(
        'yaml'          => 'metadata',
        'markdown|html' => 'content',
    );

    public function sortByPublished($a, $b)
    {
        return strcmp($b->metadata->Published, $a->metadata->Published);
    }

    public function contents($records)
    {
        $loaded_classes = array(
            'mdep' => new MarkdownExtra(),
            'spyc' => new Spyc(),
        );
        foreach ($records as $record) {
            $this->contents[] = $this->listContents($record, $loaded_classes);
        }
        usort($this->contents, array( $this, 'sortByPublished' ));

        return $this;
    }
}
