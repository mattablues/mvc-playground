<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: user.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-06, 15:33
     */

    use App\Controllers\SiteController;
    use Core\Router;

    $rout = new Router();

    // Add your first route
    $rout->add('/', function() {
        $controller = new SiteController();
        $controller->home();
    });
