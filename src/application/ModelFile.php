<?php

class ModelFile extends Cuttlefish\Model
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
