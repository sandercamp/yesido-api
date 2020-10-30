<?php

namespace Yesido;

use Symfony\Component\HttpFoundation\Response;
use DI\ContainerBuilder;
use DI\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Matcher\UrlMatcher;

final class Framework
{
    private UrlMatcher $urlMatcher;
    private ControllerResolver $controllerResolver;
    private ArgumentResolver $argumentResolver;

    public function __construct()
    {
        $container = (new ContainerBuilder())->addDefinitions(DI_DEFINITIONS)->build();

        $this->urlMatcher = $container->get(UrlMatcher::class);
        $this->controllerResolver = $container->get(ControllerResolver::class);
        $this->argumentResolver = $container->get(ArgumentResolver::class);
    }

    public function handleRequest(Request $request): Response
    {
        $this->urlMatcher->getContext()->fromRequest($request);

        $request->attributes->add($this->urlMatcher->match($request->getPathInfo()));

        $controller = $this->controllerResolver->getController($request);
        $arguments = $this->argumentResolver->getArguments($request, $controller);

        return call_user_func_array($controller, $arguments);
    }
}
