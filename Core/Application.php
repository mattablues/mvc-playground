<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: Application.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-05, 13:06
     */

    namespace Core;

    use Core\Http\Request;

    /**
     * Class Application
     * @package Core
     */
    class Application {
        public Route $router;
        public Request $request;

        public function __construct() {
            $this->request = new Request();
            $this->router = new Route($this->request);
        }

        public function run() {
            $this->router->resolve();
        }
    }