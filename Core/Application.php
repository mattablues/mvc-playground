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
        public static string $rootDir;
        public static Application $app;
        public Router $router;
        public Request $request;
        public Controller|null $controller = null;

        public function __construct(string $rootDir) {
            self::$rootDir = $rootDir;
            self::$app = $this;

            $this->request = new Request();
            $this->router = new Router();
        }

        public function getController() {
            return $this->controller;
        }

        public function setController(Controller $controller) {
            $this->controller = $controller;
        }
    }