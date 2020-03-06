<?php

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
            $Url    = new Cuttlefish\Url("/admin/$key");
            $output .= sprintf('<li><a href="%s">%s</a></li>', $Url->url_absolute, $value);
        endforeach;

        $output .= '</ul>';

        return $output;
    }

    protected function showLogin()
    {
        global $App;

        return $App->Security->login();
    }

    protected function clearCache()
    {
        global $App;
        $App->Security->maybeLoginRedirect();

        return $App->Cache->clear();
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

        $this->View = new Cuttlefish\Html($this->contents, array(
            'layout'     => 'layout.php',
            'controller' => 'admin',
            'model'      => 'page',
        ));
    }

    public function index()
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
