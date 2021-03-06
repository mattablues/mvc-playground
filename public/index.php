<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: index.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-01, 20:39
     */


    require_once '../vendor/autoload.php';

    use Core\Router;

    $app = new \Core\Application();

    // Add base route (startpage)
    Router::add('/',function(){
        echo 'Welcome :-)';
    });


    Router::add('/foo/([0-9]*)/bar',function($var1){
        var_dump($_GET);
        echo $var1.' is a great number!';
    });

    Router::run('/');