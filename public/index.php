<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: index.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-01, 20:39
     */

    require_once '../vendor/autoload.php';

    use App\Application;

    $app = new Application();

    $app->router->get('/', function() {
        return 'Hello World';
    });

    $app->router->get('/contact', function() {
        return 'Contact';
    });

    $app->run();