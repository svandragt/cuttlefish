<?php

namespace Cuttlefish\Blog;

use Cuttlefish\Model;

class ModelPost extends Model
{
    public array $structure = [
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
            $this->items[] = $this->getContent($record);
        }
        usort($this->items, [ $this, 'sortByPublished' ]);
    }
}
