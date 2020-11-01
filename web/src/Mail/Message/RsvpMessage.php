<?php

namespace Yesido\Mail\Message;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class RsvpMessage
{
    public static function fromRequest(Request $request): Email
    {
        return (new Email())
            ->from(new Address('info@sanderenellengaantrouwen.nl', 'Website'))
            ->to('info@sanderenellengaantrouwen.nl')
            ->subject('RSVP ingevuld')
            // TODO: template
            ->text('Er is een RSVP ingevuld');
    }
}
