<?php

namespace Yesido;

use Symfony\Component\HttpFoundation\Response;
use DI\ContainerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Throwable;
use Yesido\ConfigReader;

final class Framework
{
    private UrlMatcher $urlMatcher;
    private ControllerResolver $controllerResolver;
    private ArgumentResolver $argumentResolver;
    private ConfigReader $configReader;

    public function __construct()
    {
        $container = (new ContainerBuilder())
            ->enableCompilation(CACHE)
            ->addDefinitions(DI_DEFINITIONS)
            ->build();

        $this->urlMatcher = $container->get(UrlMatcher::class);
        $this->controllerResolver = $container->get(ControllerResolver::class);
        $this->argumentResolver = $container->get(ArgumentResolver::class);
        $this->configReader = $container->get(ConfigReader::class);
    }
    
    /**
     * Matches the request to a controller action
     *
     * @param Request $request
     * @return Response
     */
    public function handleRequest(Request $request): Response
    {
        if ($request->headers->get('Origin') !== $this->configReader->get('allowedOrigin')) {
            return new Response('', Response::HTTP_UNAUTHORIZED);
        }

        $this->urlMatcher->getContext()->fromRequest($request);

        try {
            $urlMatch = $this->urlMatcher->match($request->getPathInfo());
        } catch (ResourceNotFoundException $e) {
            return new Response('', Response::HTTP_NOT_FOUND);
        } catch (MethodNotAllowedException $e) {
            return new Response('', Response::HTTP_METHOD_NOT_ALLOWED);
        }

        $request->attributes->add($urlMatch);

        $response = call_user_func_array(
            $controller = $this->controllerResolver->getController($request), 
            $this->argumentResolver->getArguments($request, $controller)
        );

        $response->headers->set('Access-Control-Allow-Origin', $this->configReader->get('allowedOrigin'));
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type');

        return $response;
    }
}
