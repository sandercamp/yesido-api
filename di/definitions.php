<?php

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Yesido\Controller;

return [
    RouteCollection::class => function () {
        $routeCollection = new RouteCollection();

        $routeCollection
            ->add('test', new Route('/test', ['_controller' => [Controller::class, 'index']]));

        return $routeCollection;
    },

    ArgumentResolver::class => DI\autowire(),
    Controller::class => DI\autowire(),
    ControllerResolver::class => DI\autowire(),
    RequestContext::class => DI\autowire(),
    UrlMatcher::class => DI\autowire(),
];
