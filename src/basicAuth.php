<?php

namespace src;

use Slim\Middleware\HttpBasicAuthentication;

function basicAuth():HttpBasicAuthentication
{
    return new HttpBasicAuthentication([
        "users"=>[
            "root"=>"teste123"
        ]
    ]);

}