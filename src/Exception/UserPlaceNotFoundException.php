<?php

namespace App\Exception;

use RuntimeException;

class UserPlaceNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('No such place in the line');
    }
}
