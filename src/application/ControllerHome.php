<?php

class ControllerHome extends Cuttlefish\Controller
{
    // list of recent posts
    /**
     * @return void
     */
    public function records()
    {
        $limit         = Configuration::POSTS_HOMEPAGE;
        $Files         = new Cuttlefish\Files(array( 'url' => '/content/posts' ), $this->ext);
        $this->records = $Files->limit($limit + 5);
    }

    /**
     * @return void
     */
    public function model()
    {
        $Model       = new ModelPost($this->records);
        $this->Model = $Model->limit(Configuration::POSTS_HOMEPAGE);
    }

    /**
     * @return void
     */
    public function view()
    {
        parent::view();

        $this->View = new Cuttlefish\Html($this->Model->contents, array(
            'layout'     => 'layout.php',
            'controller' => 'home',
            'model'      => 'post',
        ));
    }
}
