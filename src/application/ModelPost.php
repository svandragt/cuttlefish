<?php

namespace Cuttlefish\Blog;

use Cuttlefish\Model;

class ModelPost extends Model
{
    /* field => transform */
    public array $fields = [
        'metadata' => 'metadatareader',
        'content'  => 'markdown',
    ];
    public string $name = 'post';

    public function sortByPublished($a, $b): int
    {
        return strcmp($b->metadata->published, $a->metadata->published);
    }

    public function contents($records): void
    {
        foreach ($records as $record) {
            $this->contents[] = $this->listContents($record);
        }
        usort($this->contents, [ $this, 'sortByPublished' ]);
    }
}
