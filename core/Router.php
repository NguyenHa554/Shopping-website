<?php
// ============================================================
// SONNE – Router
// Supports GET/POST with named params like {slug} or {id}
// ============================================================

class Router {
    private array $routes = [];

    public function get(string $path, string $handler): void {
        $this->add('GET', $path, $handler);
    }

    public function post(string $path, string $handler): void {
        $this->add('POST', $path, $handler);
    }

    private function add(string $method, string $path, string $handler): void {
        // Convert {param} to named capture group
        $pattern = preg_replace('/\{([^}]+)\}/', '(?P<$1>[^/]+)', $path);
        $pattern = '#^' . $pattern . '$#';
        $this->routes[] = compact('method', 'pattern', 'handler');
    }

    public function dispatch(): void {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        // Support method override for forms
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }

        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        // Strip base path prefix
        $base = '/2212288/Web/sonne';
        if (str_starts_with($uri, $base)) {
            $uri = substr($uri, strlen($base));
        }
        $uri = '/' . ltrim($uri, '/');
        if ($uri !== '/' ) $uri = rtrim($uri, '/');

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) continue;
            if (!preg_match($route['pattern'], $uri, $matches)) continue;

            // Extract named params
            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

            [$class, $action] = explode('@', $route['handler']);

            if (!class_exists($class)) {
                $this->notFound("Controller {$class} not found.");
                return;
            }
            $controller = new $class();
            if (!method_exists($controller, $action)) {
                $this->notFound("Action {$action} not found in {$class}.");
                return;
            }
            $controller->$action($params);
            return;
        }

        $this->notFound("No route matched: {$method} {$uri}");
    }

    private function notFound(string $msg = 'Page not found'): void {
        http_response_code(404);
        if (file_exists(__DIR__ . '/../views/errors/404.php')) {
            require __DIR__ . '/../views/errors/404.php';
        } else {
            echo '<h1>404 – Page Not Found</h1><p>' . htmlspecialchars($msg) . '</p>';
        }
    }
}
