<?php

namespace Cuttlefish\Blog;

use Cuttlefish\Model;

class ModelFile extends Model
{
    public $name = 'file';

    // File model
    public $model = array();

    /**
     * @return void
     */
    public function contents($records)
    {
        $this->contents = $records;
    }
}
