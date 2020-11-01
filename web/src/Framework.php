<?php

namespace Yesido;

use Symfony\Component\HttpFoundation\Response;
use DI\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;

final class Framework
{
    private UrlMatcher $urlMatcher;
    private ControllerResolver $controllerResolver;
    private ArgumentResolver $argumentResolver;

    public function __construct()
    {
        $container = (new ContainerBuilder())
            //->enableCompilation(CACHE)
            ->addDefinitions(DI_DEFINITIONS)
            ->build();

        $this->urlMatcher = $container->get(UrlMatcher::class);
        $this->controllerResolver = $container->get(ControllerResolver::class);
        $this->argumentResolver = $container->get(ArgumentResolver::class);
    }
    
    /**
     * Matches the request to a controller action
     *
     * @param Request $request
     * @return Response
     */
    public function handleRequest(Request $request): Response
    {
        $this->urlMatcher->getContext()->fromRequest($request);

        try {
            $urlMatch = $this->urlMatcher->match($request->getPathInfo());
        } catch (ResourceNotFoundException $e) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $request->attributes->add($urlMatch);

        return call_user_func_array(
            $controller = $this->controllerResolver->getController($request), 
            $this->argumentResolver->getArguments($request, $controller)
        );
    }
}
