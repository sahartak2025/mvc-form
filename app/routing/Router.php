<?php

namespace app\routing;

use app\controllers\BaseController;

class Router
{
    protected array $routes = [];

    public function __construct()
    {
        $this->routes = require 'routes.php';
    }

    public function runAction(): mixed
    {
        $requestPath = $_SERVER['REQUEST_URI'];
        if (!isset($this->routes[$requestPath])) {
            http_response_code(404);
            exit;
        }
        $controllerData = $this->routes[$requestPath];
        $className = $controllerData[0];
        $methodName = $controllerData[1];
        /**@var BaseController $controller*/
        $controller = new $className;
        $controller->initCsrf();
        $controller->checkCsrf();

        return $controller->$methodName();
    }
}