<?php

use Yesido\Framework;
use Symfony\Component\HttpFoundation\Request;

require sprintf('%s/vendor/autoload.php', __DIR__);

(
    function() {
        try {
            (new Framework())
            ->handleRequest(Request::createFromGlobals())
            ->send();
        } catch (Throwable $t) {
            header('HTTP/1.1 500 Internal Server Error');
        }
    }
)();
