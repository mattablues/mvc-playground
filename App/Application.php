<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: Application.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-01, 20:17
     */

    namespace App;

    use Core\Http\Request;
    use Core\Http\Response;
    use Core\Router;

    /**
     * Class Application
     */
    class Application {
        public Router $router;
        public Request $request;
        public Response $response;

        public function __construct() {
            $this->request = new Request();
            $this->response = new Response();
            $this->router = new Router($this->request, $this->response);
        }

        protected array $routes = [];

        public function get($path, $callback) {
            $this->routes['get'][$path] = $callback;
        }

        public function run() {
            echo $this->router->resolve();
        }
    }