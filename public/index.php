<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: index.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-01, 20:39
     */

    use Core\Http\Request;
    use Core\Router;

    require_once '../vendor/autoload.php';

    $router = new Router();

// map homepage
    $router->map('GET', '/', function() {
        return 'hello succer';
    });

// dynamic named route
/*    $router->map('GET|POST', '/users/[i:id]/', function($id) {
        $user = .....
  require __DIR__ . '/views/user/details.php';
}, 'user-details');*/

// echo URL to user-details page for ID 5
    echo $router->generate('user-details', ['id' => 5]); // Output: "/users/5"

var_dump($router);