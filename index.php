<?php

use Yesido\Framework;
use Symfony\Component\HttpFoundation\Request;

require sprintf('%s/vendor/autoload.php', __DIR__);

(fn() => (new Framework())->handleRequest(Request::createFromGlobals())->send())();
