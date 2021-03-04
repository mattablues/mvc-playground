<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: HandlerResolverInterface.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-04, 21:46
     */

    namespace Core\Interfaces;

    /**
     * Interface HandlerResolverInterface
     * @package Core\Interfaces
     */
    interface HandlerResolverInterface {
        public function resolve($handler);
    }