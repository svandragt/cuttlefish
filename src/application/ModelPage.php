<?php

namespace Cuttlefish\Blog;

use Cuttlefish\Model;

class ModelPage extends Model
{
    public array $fields = [
        'content' => 'markdown',
    ];

    public function contents($records): void
    {
        foreach ($records as $record) {
            $this->contents[] = $this->listContents($record);
        }
    }
}
