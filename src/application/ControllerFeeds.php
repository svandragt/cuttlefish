<?php

class ControllerFeeds extends Cuttlefish\Controller
{
    // single feed
    public function records()
    {
        $limit         = Configuration::POSTS_HOMEPAGE;
        $Records       = new Cuttlefish\Files(array( 'url' => '/content/posts' ), $this->ext);
        $this->records = $Records->limit($limit + 5);
    }

    public function model()
    {
        $Model       = new ModelPost($this->records);
        $this->Model = $Model->limit(10);
    }

    public function view()
    {
        parent::view();
        $this->View = new Cuttlefish\Feed($this->Model->contents);
    }
}
