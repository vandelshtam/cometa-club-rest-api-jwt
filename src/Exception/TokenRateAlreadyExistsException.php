<?php

namespace App\Exception;

use RuntimeException;

class TokenRateAlreadyExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Failed to create new record, only one token rate record can be created');
    }
}
