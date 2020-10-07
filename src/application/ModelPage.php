<?php

namespace Cuttlefish\Blog;

use Cuttlefish\Model;

class ModelPage extends Model
{
    // page model

    /**
     * @var string[]
     *
     * @psalm-var array{markdown: string}
     */
    public array $model = array(
        'markdown' => 'content',
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
