<?php

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Yesido\ConfigReader;
use Yesido\Controller;
use Yesido\Mail\Controller as MailController;

return [
    Mailer::class => function() {
        return new Mailer(
            Transport::fromDsn('smtp://info@sanderenellengaantrouwen.nl:esdNCwnDa9ofsy9wtdSV@smtp.strato.com:465')
        );
    },

    RouteCollection::class => function(ContainerInterface $container) {
        $routeCollection = new RouteCollection();

        $routes = include(ROUTES);
        foreach ($routes as $route) {
            $routeCollection->add(
                $route['name'], 
                (new Route($route['path']))
                    ->addDefaults(
                        [
                            '_controller' => [
                                $container->get($route['controller']), 
                                $route['method']
                            ]
                        ]
                    )
                    ->setMethods($route['httpMethods'])
            );
        }

        return $routeCollection;
    },

    ArgumentResolver::class => DI\autowire(),
    ConfigReader::class => DI\autowire(),
    Controller::class => DI\autowire(),
    ControllerResolver::class => DI\autowire(),
    MailController::class => DI\autowire(),
    RequestContext::class => DI\autowire(),
    UrlMatcher::class => DI\autowire(),
];
