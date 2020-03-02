<?php

class ModelFile extends Cuttlefish\Model
{

    // File model

    public $model = array();

    function contents($records)
    {
        $this->contents = $records;
    }
}
