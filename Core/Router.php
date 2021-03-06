<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: Router.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-05, 13:05
     */

    namespace Core;

    use Closure;
    use Core\Exceptions\MethodNotAllowedException;
    use Core\Exceptions\NotFoundException;
    use Core\Middlewares\AdminMiddleware;
    use Core\Middlewares\AuthMiddleware;

    /**
     * Class Router
     * @package Core
     */
    class Router {
        private array $routes = [];
        private Closure|null $pathNotFound = null;
        private Closure|null $methodNotAllowed = null;
        private array $allowedFilters = [
            'csrf', 'auth', 'admin'
        ];

        /**
         * Function used to add a new route
         * @param string $expression
         * @param Closure|string $callable
         * @param string|array $method
         * @param array|null $middleware
         */
        public function add(string $expression, Closure|string $callable, string|array $method = 'get', ?array $middleware = null) {
            array_push($this->routes, [
                'expression' => $expression,
                'callable' => $callable,
                'method' => $method,
            ]);

            if(is_array($middleware)) {
                $this->middlewares($middleware);
            }
        }

        /**
         * Path not found
         * @param $callable
         * @return void
         */
        public function pathNotFound($callable) {
            $this->pathNotFound = $callable;
        }

        /**
         * Method not allowed
         * @param $callable
         * @return void
         */
        public  function methodNotAllowed(Closure $callable): void {
            $this->methodNotAllowed = $callable;
        }

        /**
         * Run
         * @param string $basePath
         * @param bool $caseMatters
         * @param bool $trailingSlashMatters
         * @param bool $multimatch
         * @return void
         */
        public function run(string $basePath = '', bool $caseMatters = false, bool $trailingSlashMatters = false, bool $multimatch = false): void {

            // The basePath never needs a trailing slash
            // Because the trailing slash will be added using the route expressions
            $basePath = rtrim($basePath, '/');

            // Parse current URL
            $parsedUrl = parse_url($_SERVER['REQUEST_URI']);

            $path = '/';

            // If there is a path available
            if(isset($parsedUrl['path'])) {
                // If the trailing slash matters
                if($trailingSlashMatters) {
                    $path = $parsedUrl['path'];
                }
                else {
                    // If the path is not equal to the base path (including a trailing slash)
                    if($basePath.'/'!=$parsedUrl['path']) {
                        // Cut the trailing slash away because it does not matters
                        $path = rtrim($parsedUrl['path'], '/');
                    }
                    else {
                        $path = $parsedUrl['path'];
                    }
                }
            }

            $path = urldecode($path);

            // Get current request method
            $method = $_SERVER['REQUEST_METHOD'];

            $pathMatchFound = false;

            $routeMatchFound = false;

            foreach($this->routes as $route) {
                // If the method matches check the path

                // Add basePath to matching string
                if($basePath != '' && $basePath != '/') {
                    $route['expression'] = '('.$basePath.')'.$route['expression'];
                }

                // Add 'find string start' automatically
                $route['expression'] = '^'.$route['expression'];

                // Add 'find string end' automatically
                $route['expression'] = $route['expression'].'$';

                // Check path match
                if(preg_match('#'.$route['expression'].'#'.($caseMatters ? '' : 'i').'u', $path, $matches)) {
                    $pathMatchFound = true;

                    // Cast allowed method to array if it's not one already, then run through all methods
                    foreach((array)$route['method'] as $allowedMethod) {
                        // Check method match
                        if(strtolower($method) == strtolower($allowedMethod)) {
                            array_shift($matches); // Always remove first element. This contains the whole string

                            if($basePath != '' && $basePath != '/') {
                                array_shift($matches); // Remove basepath
                            }

                            if($returnValue = call_user_func_array($route['callable'], $matches)) {
                                echo $returnValue;
                            }


                            $routeMatchFound = true;

                            // Do not check other routes
                            break;
                        }
                    }
                }

                // Break the loop if the first found route is a match
                if($routeMatchFound && !$multimatch) {
                    break;
                }

            }

            // No matching route was found
            if(!$routeMatchFound) {
                // But a matching path exists
                if($pathMatchFound) {
                    if($this->methodNotAllowed) {
                        call_user_func_array($this->methodNotAllowed, [$path,$method]);
                    }
                }
                else {
                    if($this->pathNotFound) {
                        call_user_func_array($this->pathNotFound, [$path]);
                    }
                }
            }
        }

        /**
         * @param array $middlewares
         * @return bool
         */
        function middlewares(array $middlewares) {
            $middlewarePassed = [];


            foreach($middlewares as $middleware) {
                if(in_array($middleware, $this->allowedFilters)) {
                    $middlewarePassed[] = $middleware;
                }
            }

            $loggedin = true;

            foreach($middlewarePassed as $middleware) {
                if($middleware === 'auth') {
                    $loggedin = false;
                    AuthMiddleware::execute();
                }
                if($loggedin === true && $middleware === 'admin') {
                    AdminMiddleware::execute();
                }
            }
        }

        /**
         * @return mixed
         */
        protected function path(): mixed {
            $path = $_SERVER['REQUEST_URI'] ?? '/';
            $position = strpos($path, '?');

            if($position === false) {
                return $path;
            }

            return substr($path, 0, $position);
        }
    }