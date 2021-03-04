<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: Route.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-04, 21:50
     */

    namespace Core\Routes;

    /**
     * Class Route
     * @package Core\Routes
     */
    class Route {
        /**
         * Filters
         */
        const BEFORE = 'before';
        const AFTER = 'after';
        const PREFIX = 'prefix';

        /**
         * HTTP Methods constants
         */
        const ANY = 'ANY';
        const GET = 'GET';
        const HEAD = 'HEAD';
        const POST = 'POST';
        const PUT = 'PUT';
        const PATCH = 'PATCH';
        const DELETE = 'DELETE';
        const OPTIONS = 'OPTIONS';
    }