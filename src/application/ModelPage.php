<?php

namespace Cuttlefish\Blog;

use Cuttlefish\Model;

class ModelPage extends Model
{
    // page model

    public $model = array(
        'content' => 'markdown',
    );

    /**
     * @return void
     */
    public function contents($records)
    {
        foreach ($records as $record) {
            $this->contents[] = $this->listContents($record);
        }
    }
}
