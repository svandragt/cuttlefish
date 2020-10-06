<?php

namespace Cuttlefish\Blog;

use Cuttlefish\Controller;
use Cuttlefish\Html;
use Cuttlefish\Url;

class ControllerAdmin extends Controller
{
    public array $allowed_methods = array(
        'index'        => 'Overview',
        'clearCache'   => 'Clear cache',
        'generateSite' => 'Generate static site',
        'logout'       => 'Logout',
    );

    // admin section does not use content files
    protected string $contents;

    protected function isAllowedMethod($action): bool
    {
        return array_key_exists($action, $this->allowed_methods);
    }

    protected function showTasks(): string
    {
        $output = '<ul>';
        $am     = $this->allowed_methods;
        array_shift($am);
        foreach ($am as $key => $value) :
            $Url    = new Url("/admin/$key");
            $output .= sprintf('<li><a href="%s">%s</a></li>', $Url->url_absolute, $value);
        endforeach;

        $output .= '</ul>';

        return $output;
    }

    protected function showLogin(): string
    {
        global $App;

        return $App->Security->login();
    }

    protected function clearCache()
    {
        global $App;
        $App->Security->maybeLoginRedirect();

        return sprintf('<pre>%s</pre>', $App->Cache->clear());
    }

    protected function generateSite(): void
    {
        global $App;

        $App->Security->maybeLoginRedirect();
        echo $App->Cache->generateSite();
    }


    /**
     * @return void
     */
    public function init()
    {
        global $App;
        $App->Cache->abort();

        $action = ( isset($this->args[0]) ) ? $this->args[0] : 'index';
        if ($this->isAllowedMethod($action)) {
            $this->contents = $this->$action();
        } else {
            exit("Method $action is not allowed");
        }

        parent::init();
    }

    /**
     * @return void
     */
    public function view()
    {
        parent::view();

        $this->View = new Html($this->contents, array(
            'layout'     => 'layout.php',
            'controller' => 'admin',
            'model'      => 'page',
        ));
    }

    public function index(): string
    {
        global $App;
        if ($App->Security->isLoggedIn()) {
            return $this->showTasks();
        }

        return $this->showLogin();
    }

    public function logout()
    {
        global $App;

        $App->Security->maybeLoginRedirect();

        return $App->Security->logout();
    }
}
