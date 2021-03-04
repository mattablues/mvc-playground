<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: Request.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-01, 21:13
     */

    namespace Core\Http;

    use App\Interfaces\RequestInterface;
    use phpDocumentor\Reflection\DocBlock\Tags\Return_;

    /**
     * Class Request
     * @package Core\Http
     * @method requestMethod()
     */
    class Request implements RequestInterface {


        public function __construct() {
            $this->bootstrapSelf();
        }

        /**
         * @return array|bool
         */
        public function getBody(): array|bool {
            if($this->requestMethod() === 'GET') {
                return true;
            }

            if($this->requestMethod() === 'POST') {
                $body = [];

                foreach($_POST as $key => $value) {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }

                return $body;
            }
        }

        private function bootstrapSelf() {
            foreach($_SERVER as $key => $value) {
                $this->{$this->toCamelCase($key)} = $value;
            }
        }

        private function toCamelCase(string $string): string {
            $result = strtolower($string);

            preg_match_all('/_[a-z]/', $result, $matches);

            foreach($matches[0] as $match) {
                $camelCase = str_replace('_', '', strtoupper($match));
                $result = str_replace($match, $camelCase, $result);
            }

            return $result;
        }
    }