<?php

namespace App\Core;

class Router {
    private array $routes = [];

    public function get(string $path, array $handler): void {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, array $handler): void {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, array $handler): void {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch(): void {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            $pattern = $this->convertToRegex($route['path']);
            
            if ($route['method'] === $method && preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                [$controller, $action] = $route['handler'];
                
                $controllerInstance = new $controller();
                call_user_func_array([$controllerInstance, $action], $matches);
                return;
            }
        }

        http_response_code(404);
        echo "404 - Page Not Found";
    }

    private function convertToRegex(string $path): string {
        $path = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_]+)', $path);
        return '#^' . $path . '$#';
    }
}