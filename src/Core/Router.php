<?php
/**
 * @author Daniel Schreiner <schreiner.daniel@gmail.com>
 */

namespace Core;

class Router
{
    private $routes = [];

    public function addRoute($method, $uri, $controller, $action)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'action' => $action,
        ];
    }

    public function handleRequest($requestMethod, $uri)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $this->matchesUri($route['uri'], $uri)) {
                $controller = "Controllers\\" . $route['controller'];
                $action = $route['action'];

                $params = $this->extractUriParams($route['uri'], $uri);

                $controllerInstance = new $controller();
                if (method_exists($controllerInstance, $action)) {
                    $controllerInstance->$action($params);
                } else {
                    http_response_code(404);
                    echo "Route not found.";
                }

                return;
            }
        }

        http_response_code(404);
        echo "Route not found.";
    }

    private function matchesUri($routeUri, $requestUri)
    {
        $routeParts = explode('/', $routeUri);
        $requestParts = explode('/', $requestUri);

        if (count($routeParts) !== count($requestParts)) {
            return false;
        }

        for ($i = 0; $i < count($routeParts); $i++) {
            if ($routeParts[$i] !== $requestParts[$i] && strpos($routeParts[$i], '{') === false) {
                return false;
            }
        }

        return true;
    }

    private function extractUriParams($routeUri, $requestUri)
    {
        $routeParts = explode('/', $routeUri);
        $requestParts = explode('/', $requestUri);

        $params = [];

        for ($i = 0; $i < count($routeParts); $i++) {
            if (strpos($routeParts[$i], '{') !== false) {
                $paramName = trim($routeParts[$i], '{}');
                $params[$paramName] = $requestParts[$i];
            }
        }

        return $params;
    }
}
