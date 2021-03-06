<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: index.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-01, 20:39
     */


    use Core\Application;
    use Core\Exceptions\MethodNotAllowedException;
    use Core\Exceptions\NotFoundException;

    require_once '../vendor/autoload.php';
    require_once '../routes/site.php';
    require_once '../routes/auth.php';
    require_once '../routes/user.php';
    require_once '../routes/admin.php';

    /** @var $rout */

    $app = new Application(dirname(__DIR__));


    try {
        $rout->run('/');
    }
    catch(MethodNotAllowedException | NotFoundException $e) {
        echo $e->getMessage();
    }
