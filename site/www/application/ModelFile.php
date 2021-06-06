<?php

namespace Cuttlefish\Blog;

use Cuttlefish\Model;

class ModelFile extends Model
{
    public string $name = 'file';

    // File model
    public array $fields = [];

    /**
     * @return void
     */
    public function contents($records): void
    {
        $this->contents = $records;
    }
}
