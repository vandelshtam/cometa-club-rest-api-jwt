<?php

namespace App\Exception;

use RuntimeException;

class UserTableNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('data for the requested user was not found');
    }
}
