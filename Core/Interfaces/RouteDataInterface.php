<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: RouteDataInterface.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-04, 21:48
     */

    namespace Core\Interfaces;

    /**
     * Interface RouteDataInterface
     * @package Core\Interfaces
     */
    interface RouteDataInterface {
        public function getStaticRoutes(): array;
        public function getVariableRoutes(): array;
        public function getFilters(): array;
    }