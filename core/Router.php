<?php

/**
 * Router Class
 * Handles URL routing for the application
 */
class Router
{
    private array $routes = [];
    private array $middlewares = [];

    /**
     * Add a GET route
     */
    public function get(string $path, string $controller, string $action, array $middleware = []): void
    {
        $this->addRoute('GET', $path, $controller, $action, $middleware);
    }

    /**
     * Add a POST route
     */
    public function post(string $path, string $controller, string $action, array $middleware = []): void
    {
        $this->addRoute('POST', $path, $controller, $action, $middleware);
    }

    /**
     * Add a PUT route (using POST with _method)
     */
    public function put(string $path, string $controller, string $action, array $middleware = []): void
    {
        $this->addRoute('PUT', $path, $controller, $action, $middleware);
    }

    /**
     * Add a DELETE route (using POST with _method)
     */
    public function delete(string $path, string $controller, string $action, array $middleware = []): void
    {
        $this->addRoute('DELETE', $path, $controller, $action, $middleware);
    }

    /**
     * Add a route to the routes array
     */
    private function addRoute(string $method, string $path, string $controller, string $action, array $middleware): void
    {
        // Convert route parameters to regex pattern
        $pattern = preg_replace('/\{([a-zA-Z]+)\}/', '(?P<$1>[^/]+)', $path);
        $pattern = '#^' . $pattern . '$#';

        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'pattern' => $pattern,
            'controller' => $controller,
            'action' => $action,
            'middleware' => $middleware,
        ];
    }

    /**
     * Dispatch the request to the appropriate controller
     */
    public function dispatch(): void
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Define the base path for the application
        $basePath = '/blog-post';
        
        // Remove base path from request URI
        if (strpos($requestUri, $basePath) === 0) {
            $requestUri = substr($requestUri, strlen($basePath));
        }
        
        // Ensure URI starts with /
        if (empty($requestUri) || $requestUri[0] !== '/') {
            $requestUri = '/' . $requestUri;
        }
        
        // Remove trailing slash except for root
        if ($requestUri !== '/' && substr($requestUri, -1) === '/') {
            $requestUri = rtrim($requestUri, '/');
        }

        // Handle method spoofing for PUT/DELETE
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if ($requestMethod === 'POST' && isset($_POST['_method'])) {
            $requestMethod = strtoupper($_POST['_method']);
        }

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            if (preg_match($route['pattern'], $requestUri, $matches)) {
                // Run middleware
                foreach ($route['middleware'] as $middleware) {
                    $middlewareClass = $middleware . 'Middleware';
                    $middlewarePath = BASE_PATH . '/middleware/' . $middlewareClass . '.php';
                    
                    if (file_exists($middlewarePath)) {
                        require_once $middlewarePath;
                        $middlewareInstance = new $middlewareClass();
                        
                        if (!$middlewareInstance->handle()) {
                            return;
                        }
                    }
                }

                // Extract route parameters
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Load and instantiate the controller
                $controllerPath = BASE_PATH . '/app/controllers/' . $route['controller'] . '.php';
                
                if (!file_exists($controllerPath)) {
                    throw new Exception("Controller '{$route['controller']}' not found.");
                }

                require_once $controllerPath;
                
                $controllerClass = basename($route['controller']);
                $controller = new $controllerClass();
                $action = $route['action'];

                if (!method_exists($controller, $action)) {
                    throw new Exception("Action '{$action}' not found in controller '{$controllerClass}'.");
                }

                // Call the controller action with parameters
                call_user_func_array([$controller, $action], $params);
                return;
            }
        }

        // No route found - 404
        http_response_code(404);
        require_once BASE_PATH . '/app/views/errors/404.php';
    }
}

