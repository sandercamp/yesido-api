<?php

namespace Yesido\Mail\Message;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class RsvpMessage
{
    public static function fromRequest(Request $request): Email
    {
        // TODO: Sanitize input
        $isComing = (bool)$request->get('confirmation');

        $email = $request->get('email');
        $name = $request->get('name');
        $message = $request->get('message');

        return (new Email())
            ->from(new Address($email, 'Website'))
            ->to('info@sanderenellengaantrouwen.nl')
            ->subject(sprintf('RSVP ingevuld door %s', $name))
            // TODO: template
            ->text($message);
    }
}
