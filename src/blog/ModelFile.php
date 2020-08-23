<?php

namespace Cuttlefish\Blog;

use Cuttlefish\Model;

class ModelFile extends Model
{

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
