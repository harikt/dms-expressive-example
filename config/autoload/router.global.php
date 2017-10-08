<?php

use Zend\Expressive\Router\AuraRouter;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\RouterInterface;

return [
    'dependencies' => [
        'invokables' => [
            // RouterInterface::class => AuraRouter::class,
            RouterInterface::class => FastRouteRouter::class,
        ],
    ],
];
