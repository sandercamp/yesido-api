<?php

namespace Yesido\Mail;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Yesido\Mail\Message\RsvpMessage;

class Controller
{    
    private Mailer $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }
   
    /**
     * Sends out an email containing RSVP details
     *
     * @param Request $request
     * 
     * @return Response
     */
    public function rsvp(Request $request): Response
    {
        $this->mailer->send(RsvpMessage::fromRequest($request));

        return new Response('', Response::HTTP_CREATED);
    }
}
