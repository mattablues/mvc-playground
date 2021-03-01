<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: Router.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-01, 20:53
     */

    namespace Core;

    use Core\Http\Request;

    /**
     * Class Router
     * @package Core
     */
    class Router {
        public Request $request;
        protected array $routes = [];

        /**
         * Router constructor.
         * @param Request $request
         */
        public function __construct(Request $request) {
            $this->request = $request;
        }

        public function get(string $path, callable $callback) {
            $this->routes['get'][$path] = $callback;
        }

        public function resolve() {
            $path = $this->request->path();
            $method = $this->request->method();

            $callback = $this->routes[$method][$path] ?? false;

            if($callback === false) {
                echo 'Page Not Found';
                exit();
            }

            echo call_user_func($callback);
        }
    }