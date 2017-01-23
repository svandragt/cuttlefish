<?php

namespace VanDragt\Carbon;

if (!defined('BASE_FILEPATH')) {
    exit('No direct script access allowed');
}

class Collection
{

    private $collection;

    public function getCollection()
    {
        return $this->collection;
    }

    public function setCollection($value)
    {
        $this->collection = $value;
    }
}
