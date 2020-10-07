<?php

namespace Cuttlefish\Blog;

use Cuttlefish\Model;

class ModelFile extends Model
{

    // File model

    /**
     * @var array
     */
    public array $model = array();

    /**
     * @return void
     */
    public function contents($records)
    {
        $this->contents = $records;
    }
}
