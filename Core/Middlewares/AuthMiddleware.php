<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: AuthMiddleware.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-06, 16:32
     */

    namespace Core\Middlewares;

    use App\Controllers;
    use Core\Application;
    use phpDocumentor\Reflection\DocBlock\Tags\BaseTag;

    /**
     * Class AuthMiddleware
     * @package Core\Middlewares
     */
    class AuthMiddleware extends BaseMiddleware {
        public static function isLoggedIn(): bool {
            return true;
        }

        public static function execute(): void {
            if(!self::isLoggedIn()) {
                echo 'not logged in<br>';
            }
        }
    }