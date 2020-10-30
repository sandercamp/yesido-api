<?php

namespace Yesido;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Transport\Dsn;

class Controller
{    
    public function mail(Request $request): Response
    {
        return new Response('', Response::HTTP_CREATED);
    }

    public function status(Request $request): Response
    {
        return new Response('API is up and running');
    }
}
