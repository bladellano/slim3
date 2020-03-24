<?php

namespace src;

function slimConfiguration()
{
    $c = [
        'settings' => [
            'displayErrorDetails' => getenv('DISPLAY_ERRORS_DETAILS'),
        ],
    ];
    
 return new \Slim\Container($c);
    
}