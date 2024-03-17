<?php
class Router
{
    private $routes = [];

    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function put($path, $callback)
    {
        $this->routes['PUT'][$path] = $callback;
    }

    public function patch($path, $callback)
    {
        $this->routes['PATCH'][$path] = $callback;
    }

    public function delete($path, $callback)
    {
        $this->routes['DELETE'][$path] = $callback;
    }

    public function resolve($method, $uri)
    {
        $method = strtoupper($method);
        $callback = $this->routes[$method][$uri] ?? null;

        if ($callback) {
            if (is_callable($callback)) {
                call_user_func($callback);
            } else {
                echo "Error: Route handler is not callable.";
            }
        } else {
            http_response_code(404);
            header("Location: /roommates/404");
            exit;
        }
    }
}