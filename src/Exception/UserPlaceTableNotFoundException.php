<?php

namespace App\Exception;

use RuntimeException;

class UserPlaceTableNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('No such place in the line');
    }
}
