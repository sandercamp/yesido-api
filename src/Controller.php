<?php

namespace Yesido;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller
{    
    /**
     *
     * @param Request $request
     * 
     * @return Response
     */
    public function index(Request $request): Response
    {



        return new Response('test123');
    }
}
