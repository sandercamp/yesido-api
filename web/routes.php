<?php

use Yesido\Controller;
use Yesido\Mail\Controller as MailController;

require sprintf('%s/vendor/autoload.php', __DIR__);

return [
    [
        'name' => 'status',
        'path' => '/status',
        'controller' => Controller::class,
        'method' => 'status',
    ],
    [
        'name' => 'rsvp',
        'path' => '/rsvp',
        'controller' => MailController::class,
        'method' => 'rsvp',
    ]
];
