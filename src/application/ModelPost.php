<?php

namespace Cuttlefish\Blog;

use Cuttlefish\Model;

class ModelPost extends Model
{
    public $name = 'post';

    /* field => transform */
    public $model = array(
        'metadata'    => 'metadatareader',
        'content'     => 'markdown',
    );

    /**
     * @return int
     */
    public function sortByPublished($a, $b)
    {
        return strcmp($b->metadata->published, $a->metadata->published);
    }

    /**
     * @return self
     */
    public function contents($records)
    {
        foreach ($records as $record) {
            $this->contents[] = $this->listContents($record);
        }
        usort($this->contents, array( $this, 'sortByPublished' ));

        return $this;
    }
}
