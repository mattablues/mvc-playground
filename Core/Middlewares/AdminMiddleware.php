<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: AdminMiddleware.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-07, 00:02
     */

    namespace Core\Middlewares;

    /**
     * Class AdminMiddleware
     * @package Core\Middlewares
     */
    class AdminMiddleware extends BaseMiddleware {
        public static function isAdmin() {
            return false;
        }

        public static function execute(): void {
            if(!self::isAdmin()) {
                echo 'Not allowed<br>';
            }
        }
    }