<?php


class ModelPost extends Cuttlefish\Model
{

    public $model = array(
        'metadatareader'    => 'metadata',
        'markdown|html'     => 'content',
    );

    /**
     * @return int
     */
    public function sortByPublished($a, $b)
    {
        return strcmp($b->metadata->Published, $a->metadata->Published);
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
