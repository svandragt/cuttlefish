<?php

namespace Cuttlefish\Blog;

use Configuration;
use Cuttlefish\App;
use Cuttlefish\Controller;
use Cuttlefish\Feed;
use Cuttlefish\Files;

class ControllerFeeds extends Controller
{
    public static string $name = 'feed';
    public static string $contentPath = 'posts';
    // single feed
    /**
     * @return void
     */
    public function records()
    {
        $limit         = Configuration::POSTS_HOMEPAGE;
        // TODO can we use the routing table to get the model of the matching controller here
        $content_dir = $this->getContentPath(App::getInstance()->Router->routeControllers[$this->args[2]]);
        $Records = new Files($content_dir, $this->ext);
        $this->records = $Records->limit($limit + 5);
    }

    /**
     * @return void
     */
    public function model()
    {
        // TODO replace with the model
        $Model       = new ModelPost($this->records);
        $this->Model = $Model->limit(10);
    }

    /**
     * @return void
     */
    public function view()
    {
        parent::view();
        $this->View = new Feed($this->Model->contents);
    }
}
