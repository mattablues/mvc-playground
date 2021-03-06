<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: SiteController.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-01, 20:41
     */

    namespace App\Controllers;

    use Core\Controller;

    /**
     * Class SiteController
     * @package App\Controllers
     */
    class SiteController extends Controller {

        public function home() {
            echo 'home';
        }

        public function contact() {
            echo 'contact';
        }

        public function shit() {
            echo 'shit';
        }
    }