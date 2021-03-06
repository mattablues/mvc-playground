<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: index.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-01, 20:39
     */


    require_once '../vendor/autoload.php';

    use Core\Route;

    $app = new \Core\Application();

    // Add your first route
    Route::add('/', function() {
        return [\App\Controllers\SiteController::class, 'home'];
    });

// Add the first route
    Route::add('/user/([0-9]*)/edit', function($id) {
        echo 'Edit user with id '.$id.'<br>';
    }, 'get');

    Route::run('/');