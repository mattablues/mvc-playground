<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: BaseMiddleware.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-06, 23:42
     */

    namespace Core\Middlewares;

    /**
     * Class BaseMiddleware
     * @package Core\Middlewares
     */
    abstract class BaseMiddleware {
        abstract public static function execute(): void;
    }