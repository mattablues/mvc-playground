<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: site.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-06, 16:08
     */

    use App\Controllers\SiteController;

    /** @var $app  */

    $rout = new \Core\Router();
    $controller = new SiteController();

    // Add your first route
    $rout->add('/', function() use ($controller) {
        $controller->home();
    }, 'get', ['auth', 'admin']);

    // Add your first route
    $rout->add('/contact', function() use ($controller) {
        $controller->contact();
    }, 'post');

    // Add your first route
    $rout->add('/shit', function() use ($controller) {
        $controller->shit();
    }, 'post');