<?php



use VanDragt\Carbon;

if (!defined('BASE_FILEPATH')) {
    exit('No direct script access allowed');
}

class ModelFile extends Carbon\Model
{

    // File model

    public $model = array();

    function contents($records, $Environment)
    {
        $this->contents = $records;
    }

}