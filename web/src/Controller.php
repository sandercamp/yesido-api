<?php

namespace Yesido;

use Symfony\Component\HttpFoundation\Response;

class Controller
{    
    /**
     * Endpoint to check if the API is up and running
     * 
     * @return Response
     */
    public function status(): Response
    {
        return new Response();
    }
}
