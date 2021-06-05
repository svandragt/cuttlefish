<?php

namespace Cuttlefish\Blog;

use Cuttlefish\Model;

class ModelPage extends Model
{
    public array $structure = [
        'content' => 'markdown',
    ];
    public string $name = 'page';

    public function contents($records): void
    {
        foreach ($records as $record) {
            $this->items[] = $this->getContent($record);
        }
    }
}
