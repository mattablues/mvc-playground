<?php

    declare(strict_types=1);

    /**
     * Project name: mvc-playground
     * Filename: Dispatcher.php
     * @author Mats Åkebrand <mats@akebrands.se>
     * Created at: 2021-03-04, 21:54
     */

    namespace Core\Routes;

    use Core\Interfaces\HandlerResolverInterface;
    use Core\Interfaces\RouteDataInterface;

    /**
     * Class Dispatcher
     * @package Core\Routes
     */
    class Dispatcher {
        private array $staticRouteMap;
        private array $variableRoutData;
        private array $filters;
        private HandlerResolver|HandlerResolverInterface $handlerResolver;
        public $matchedRoute;

        /**
         * Dispatcher constructor.
         * @param RouteDataInterface $data
         * @param HandlerResolverInterface|null $resolver
         */
        public function __construct(RouteDataInterface $data, HandlerResolverInterface $resolver = null) {
            $this->staticRouteMap = $data->getStaticRoutes();
            $this->variableRoutData = $data->getVariableRoutes();
            $this->filters = $data->getFilters();

            if($resolver === null) {
                $this->handlerResolver = new HandlerResolver();
            }
            else {
                $this->handlerResolver = $resolver;
            }
        }

        /**
         * Dispatch a route for the given HTTP Method / URI
         * @param $httpMethod
         * @param $uri
         * @return mixed
         */
        public function dispatch($httpMethod, $uri): mixed {
            list($handler, $filters, $vars) = $this->dispatchRoute($httpMethod, trim($uri), '/');
            list($beforeFilter, $afterFilter) = $this->parseFilter($filters);

            if(($response = $this->dispatchFilters($beforeFilter)) !== null) {
                return $response;
            }

            $resolveHandler = $this->handlerResolver->resolve($handler);
            $response = call_user_func_array($resolveHandler, $vars);

            return $this->dispatchFilters($afterFilter, $response);
        }

        private function dispatchRoute($httpMethod, string $trim, string $string) {
        }

        private function parseFilter(mixed $filters) {
        }

        private function dispatchFilters(mixed $beforeFilter) {
        }
    }