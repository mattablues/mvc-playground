<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: Request.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-01, 21:13
     */

    namespace Core\Http;

    /**
     * Class Request
     * @package Core\Http
     */
    class Request {
        public function path() {
            $path = $_SERVER['REQUEST_URI'] ?? '/';

            $position = strpos($path, '?');

            if($position === false) {
                return $path;
            }

            return substr($path, 0, $position);
        }

        public function method() {
            return strtolower($_SERVER['REQUEST_METHOD']);
        }
    }