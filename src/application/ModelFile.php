<?php

class ModelFile extends Cuttlefish\Model
{

    // File model

    public $model = array();

    public function contents($records)
    {
        $this->contents = $records;
    }
}
