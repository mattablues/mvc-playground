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

    /**
     * Class Router
     * @package Core
     */
    class Route {
        private static array $routes = [];
        private static Closure|null $pathNotFound = null;
        private static Closure|null $methodNotAllowed = null;

        /**
         * Function used to add a new route
         * @param string $expression
         * @param Closure $function
         * @param string|array $method
         * @return void
         */
        public static function add(string $expression, Closure $function, string|array $method = 'get'): void{
            array_push(self::$routes, [
                'expression' => $expression,
                'function' => $function,
                'method' => $method
            ]);

        }

        /**
         * Path not found
         * @param $function
         * @return void
         */
        public static function pathNotFound($function) {
            self::$pathNotFound = $function;
        }

        /**
         * Method not allowed
         * @param $function
         * @return void
         */
        public static function methodNotAllowed(Closure $function): void {
            self::$methodNotAllowed = $function;
        }

        /**
         * Run
         * @param string $basePath
         * @param bool $caseMatters
         * @param bool $trailingSlashMatters
         * @param bool $multimatch
         * @return void
         * @throws MethodNotAllowedException
         * @throws NotFoundException
         */
        public static function run(string $basePath = '', bool $caseMatters = false, bool $trailingSlashMatters = false, bool $multimatch = false): void {

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

            foreach(self::$routes as $route) {

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

                            if($returnValue = call_user_func_array($route['function'], $matches)) {
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
                    if(self::$methodNotAllowed) {
                        call_user_func_array(self::$methodNotAllowed, [$path,$method]);
                        throw new MethodNotAllowedException();
                    }
                }
                else {
                    if(self::$pathNotFound) {
                        call_user_func_array(self::$pathNotFound, [$path]);
                        throw new NotFoundException();
                    }
                }
            }
        }
    }