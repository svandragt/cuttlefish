<?php

if (! defined('BASE_FILEPATH')) {
    exit('No direct script access allowed');
}

class ControllerAdmin extends Cuttlefish\Controller
{
    public $allowed_methods = array(
        'index'       => 'Overview',
        'clear_cache' => 'Clear cache',
        'generate'    => 'Generate static site',
        'logout'      => 'Logout',
    );
    // admin section does not use content files
    protected $contents;

    function init()
    {
        global $App;
        $App->Cache->abort();

        $action = ( isset($this->args[0]) ) ? $this->args[0] : 'index';
        if ($this->is_allowed_method($action)) {
            $this->contents = $this->$action();
        } else {
            $this->is_allowed_method_fail($action);
        }

        parent::init();
    }

    function is_allowed_method($action)
    {
        return array_key_exists($action, $this->allowed_methods);
    }

    /* admin functionality */

    function is_allowed_method_fail($action)
    {
        exit("method $action not allowed");
    }

    function view()
    {
        parent::view();

        $this->View = new Cuttlefish\Html($this->contents, array(
            'layout'     => 'layout.php',
            'controller' => 'admin',
            'model'      => 'page',
        ));
    }

    function index()
    {
        global $App;
        if ($App->Security->isLoggedIn()) {
            return $this->show_tasks();
        }

        return $this->show_login();
    }

    function show_tasks()
    {
        $output = '<ul>';
        $am     = $this->allowed_methods;
        array_shift($am);
        foreach ($am as $key => $value) :
            $Url    = new Cuttlefish\Url("/admin/$key");
            $output .= sprintf('<li><a href="%s">%s</a></li>', $Url->url_absolute, $value);
        endforeach;

        $output .= '</ul>';

        return $output;
    }

    function show_login()
    {
        global $App;

        return $App->Security->login();
    }

    function clear_cache()
    {
        global $App;
        $App->Security->maybeLoginRedirect();

        return $App->Cache->clear();
    }

    function generate()
    {
        global $App;

        $App->Security->maybeLoginRedirect();
        echo $App->Cache->generate_site();
    }

    function logout()
    {
        global $App;

        $App->Security->maybeLoginRedirect();

        return $App->Security->logout();
    }
}
