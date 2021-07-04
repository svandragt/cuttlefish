<?php

namespace Cuttlefish;

use Configuration;

/**
 * @property  controller
 */
class Router
{
    public Controller $Controller;
    public array $routeControllers = [];
    public array $args;

    public function __construct(array $routes)
    {
        $this->routeControllers = $routes;
        // Route to controller
        $this->args = explode("/", $this->pathInfo());
    }

    public function loadController(): void
    {
        $route = $this->args[1];
        if (!isset($this->routeControllers[$route])) {
            $this->classNotCallable($route);
        }
        $controller_class = $this->routeControllers[$route];

        $controller_arguments = array_slice($this->args, 2);
        if (class_exists($controller_class, true)) {
            $this->Controller = new $controller_class($controller_arguments);
            $this->Controller->init();
        } else {
            $this->classNotCallable($controller_class);
        }
    }

    public function routeFromClass($class)
    {
        $classes = array_flip($this->routeControllers);
        return $classes[$class];
    }

    /**
     * Return consistant path based on server variable and home_page path fallback
     *
     * @return string Returns information about a file path
     */
    protected function pathInfo(): string
    {
        $pathInfo = $_SERVER['PATH_INFO'] ?? '';

        $unspecifiedPath = empty($pathInfo) || $pathInfo === '/';
        if (!$unspecifiedPath) {
            $endsWithSlash = !substr(strrchr($pathInfo, "/"), 1);
            if ($endsWithSlash) {
                $slashlessRequest = substr($pathInfo, 0, -1);
                $Url = new Url($slashlessRequest);
                header('Location: ' . $Url->urlAbsolute);
                exit();
            }
        }

        if (empty($pathInfo)) {
            $pathInfo = Configuration::HOME_PAGE;
        }

        return (string)$pathInfo;
    }

    /**
     * Requesting urls without controller
     *
     * @param string $controllerClassName name of controller
     *
     * @return void
     */
    protected function classNotCallable(string $controllerClassName): void
    {
        $url = new Url('/errors/404');
        $logMessage = "Not callable '$controllerClassName' or missing parameter.";
        if (empty($controllerClassName)) {
            $logMessage = "Missing route";
        }
        http_response_code(404);
        $this->redirect($url, $logMessage);
    }

    /**
     * Redirect to new url
     *
     * @param Url $url URL to redirect to
     * @param string $logMessage
     *
     * @return void
     */
    protected function redirect(Url $url, string $logMessage): void
    {
        echo("Location: " . $url->urlAbsolute . PHP_EOL);
        exit($logMessage);
    }
}
