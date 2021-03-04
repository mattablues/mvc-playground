<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: RouteDataProviderInterface.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-04, 21:49
     */

    namespace Core\Interfaces;

    /**
     * Interface RouteDataProviderInterface
     * @package Core\Interfaces
     */
    interface RouteDataProviderInterface {
        public function getData();
    }